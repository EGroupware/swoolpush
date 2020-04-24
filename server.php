#!/usr/bin/env php
<?php
/**
 * Push Server for EGroupware using PHP Swoole extension
 *
 * Start with:
 *
 * docker run --rm -it -v $(pwd):/var/www -v /var/lib/php/sessions:/var/lib/php/sessions \
 *	--add-host memcached1:192.168.65.2 -p9501:9501 phpswoole/swoole
 *
 * Send message (you can get a token from the server output, when a client connects):
 *
 * curl -i -H 'Content-Type: application/json' -X POST 'https://boulder.egroupware.org/egroupware/push?token=<token>' \
 *	-d '{"type":"message","data":{"message":"Hi ;)","type":"notice"}}'
 *
 * @link https://www.egroupware.org
 * @author Ralf Becker <rb-At-egroupware.org>
 * @package swoolepush
 * @copyright (c) 2019 by Ralf Becker <rb-At-egroupware.org>
 * @license http://opensource.org/licenses/gpl-license.php GPL - GNU General Public License
 */

if (php_sapi_name() !== 'cli')	// security precaution: forbit calling server.php as web-page
{
	die('<h1>server.php must NOT be called as web-page --> exiting !!!</h1>');
}
if (!class_exists('Swoole\\Websocket\\Server'))
{
	echo phpinfo();
	die("\n\nPHP extension swoole not loaded!\n");
}

// this is necessary to use session_decode(), BEFORE there is any output
ini_set('session.save_path', '/var/lib/php/sessions');
if (session_status() !== PHP_SESSION_ACTIVE)
{
	session_start();
}
require __DIR__.'/vendor/autoload.php';

$table = new Swoole\Table(1024);
$table->column('session', Swoole\Table::TYPE_STRING, 40);
$table->column('user', Swoole\Table::TYPE_STRING, 40);
$table->column('instance', Swoole\Table::TYPE_STRING, 40);
$table->column('account_id', Swoole\Table::TYPE_INT);
$table->create();

$server = new Swoole\Websocket\Server("0.0.0.0", 9501);
$server->table = $table;

// read Bearer Token from Backend class
$bearer_token = EGroupware\SwoolePush\Credentials::$bearer_token;

/**
 * Callback for successful Websocket handshake
 *
 * @todo move session check before handshake
 */
$server->on('open', function (Swoole\Websocket\Server $server, Swoole\Http\Request $request)
{
	//var_dump($request);
	$sessionid = $request->cookie['sessionid'];	// Api\Session::EGW_SESSION_NAME
	$session = new EGroupware\SwoolePush\Session($sessionid); //, 'memcached1:11211,memcached2:11211', 'memcached');
	if (!$session->exists())
	{
		error_log("server: handshake success with fd{$request->fd}, FAILED with unknown sessionid=$sessionid");
		$server->close($request->fd);
	}
	else
	{
		error_log("server: handshake success with fd{$request->fd} existing sessionid=$sessionid");
	}
});

/**
 * Callback for received Websocket message
 */
$server->on('message', function (Swoole\Websocket\Server $server, Swoole\WebSocket\Frame $frame)
{
    error_log("receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}");

	if (($data = json_decode($frame->data, true)))
	{
		if (isset($data['subscribe']) && count($data['subscribe']) === 3)
		{
			$server->table->set($frame->fd, [
				'session' => $data['subscribe'][0],
				'user'    => $data['subscribe'][1],
				'instance' => $data['subscribe'][2],
				'account_id' => $data['account_id'],
			]);
			/* Success is the default ;)
			$server->push($frame->fd, json_encode([
				'type' => 'message',
				'data' => ['message' => 'Successful connected to push server :)']
			]));
			*/
		}
	}
});

/**
 * Callback for received HTTP request
 */
$server->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) use($server, $bearer_token)
{
	$token = $request->get['token'] ?? null;

	// check Bearer token
	if (!empty($bearer_token) && $bearer_token !== substr($request->header['authorization'], 7))
	{
		$response->status(401);
		$response->header('WWW-Authenticate', 'Bearer realm="EGroupware Push Server"');
		$response->end((!isset($request->header['authorization']) ? 'Missing' : 'Wrong').' Bearer Token!');
		return;
	}

	switch ($request->server['request_method'])
	{
		case 'GET':
			$msg = $request->get['msg'];
			break;
		case 'POST':
			$msg = $request->rawcontent();
			if (empty($token))
			{
				$data = json_decode($msg, true);
				$token = $data['token'];
				unset($data['token']);
				$msg = json_encode($data);
			}
			break;
	}
	/*error_log($request->server['request_method'].' '.$request->server['request_uri'].
		(!empty($request->server['query_string'])?'?'.$request->server['query_string']:'').' '.$request->server['server_protocol'].
		' from remote_addr '.$request->server['remote_addr'].', X-Forwarded-For: '.$request->header['x-forwarded-for'].' Host: '.$request->header['host']);*/
	if (!empty($token) && !empty($msg))
	{
		$send = 0;
		foreach($server->connections as $fd)
		{
			if ($server->exist($fd) && ($data = $server->table->get($fd)))
			{
				if ($token === $data['user'] || $token === $data['session'] || $token === $data['instance'])
				{
					$server->push($fd, $msg);
					++$send;
				}
			}
		}
		error_log("Pushed for $token to $send subscribers: $msg");
	    $response->header("Content-Type", "text/pain; charset=utf-8");
	    $response->end("$send subscribers notified\n");
	}
	elseif (!empty($token))
	{
		$account_ids = [];
		foreach($server->connections as $fd)
		{
			if ($server->exist($fd) && ($data = $server->table->get($fd)))
			{
				if ($token === $data['instance'])
				{
					$account_ids[] = $data['account_id'];
				}
			}
		}
		if ($account_ids) $account_ids = array_unique($account_ids);
		$count = count($account_ids);
		error_log("Returned for instance-token $token $count unique account_id's");
		$response->header("Content-Type", "application/json");
		$response->end(json_encode($account_ids));
	}
	else
	{
		// not calling $response->end() return 500 to client
		$uri = $request->server['request_uri'];
		if (!empty($request->server['query_string']))
		{
			$uri .= '?'.$request->server['query_string'];
		}
		error_log("Invalid request: {$request->server['request_method']} $uri\n".$request->rawcontent());
	}
});

/**
 * Callback for closed connection
 */
$server->on('close', function (Swoole\Websocket\Server $server, int $fd)
{
	$server->table->del($fd);

    echo "client {$fd} closed\n";
});

$server->start();