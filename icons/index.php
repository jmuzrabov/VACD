<?php

$config = [
    'cache' => [
        'dir' => __DIR__ . '/cache',
        'timeout' => 604800,
        'min-refresh' => 604800,
        'private' => false
    ],
    'cors' => [
        'allowed_domains' => [
            'https://cc-qa.yoummday.localhost',
            'https://cc.yoummday.localhost',
            'https://cc-qa.yoummday.com',
            'https://cc.yoummday.com',
            'https://cc.yd.rh',
            'https://cc-qa.yd.rh',
            'https://cc.yd.jm',
            'https://cc-qa.yd.jm',
            'https://onboarding-qa.yoummday.localhost',
            'https://onboarding.yoummday.localhost',
            'https://onboarding-qa.yoummday.com',
            'https://onboarding.yoummday.com',
            'https://onboarding.yd.rh',
            'https://onboarding-qa.yd.rh',
            'https://onboarding.yd.jm',
            'https://onboarding-qa.yd.jm',
            'https://pm-qa.yoummday.localhost',
            'https://pm.yoummday.localhost',
            'https://pm.yoummday.com',
            'https://pm-qa.yoummday.com',
            'https://pm.yd.rh',
            'https://pm-qa.yd.rh',
            'https://pm.yd.jm',
            'https://pm-qa.yd.jm',
            'https://talent-qa.yoummday.localhost',
            'https://talent.yoummday.localhost',
            'https://talent-qa.yoummday.com',
            'https://talent.yoummday.com',
            'https://talent.yd.rh',
            'https://talent-qa.yd.rh',
            'https://talent.yd.jm',
            'https://talent-qa.yd.jm'
        ],
        'origins' => '*',
        'timeout' => 86400,
        'methods' => 'GET, OPTIONS',
        'headers' => 'Origin, X-Requested-With, Content-Type, Accept, Accept-Encoding',
    ]
];

/**
 * Check cache headers
 *
 * @param $config
 */
function cacheHeaders($config)
{
    if (!$config['cache'] || !$config['cache']['timeout']) {
        return;
    }
    header('Cache-Control: ' . (empty($config['cache']['private']) ? 'public' : 'private') .
        ', max-age=' . $config['cache']['timeout'] .
        (empty($config['cache']['min-refresh']) ? '' : ', min-refresh=' . $config['cache']['min-refresh'])
    );
    if (empty($config['cache']['private'])) {
        header('Pragma: cache');
    }
}

/**
 * Send cache headers
 *
 * @param $config
 */
function sendCacheHeaders($config)
{
    // Check for caching
    $send = true;
    if (isset($_SERVER['HTTP_PRAGMA']) && strpos($_SERVER['HTTP_PRAGMA'], 'no-cache') !== false) {
        $send = false;
    } elseif (isset($_SERVER['HTTP_CACHE_CONTROL']) && strpos($_SERVER['HTTP_CACHE_CONTROL'], 'no-cache') !== false) {
        $send = false;
    }

    if ($send) {
        cacheHeaders($config);
    }
}

/**
 * Send error message
 *
 * @param int $code
 */
function sendError($code)
{
    http_response_code($code);
    switch ($code) {
        case 400:
            echo 'Bad request';
            break;
        case 500:
            echo 'Something went wrong';
            break;
        case 404:
            echo 'Not found';
            break;
    }
}

/**
 * Parse query
 *
 * @param string $prefix
 * @param string $query
 * @param string $ext
 */
function parseRequest($prefix, $query, $ext)
{
    global $config;

    // Parse query
    $result = [];

    if ($ext == 'js' || $ext == 'json') {
        if ($query !== 'icons' || !isset($_GET['icons']) || !is_string($_GET['icons'])) {
            sendError(404);
            exit(0);
        }
        // preparing output
        $result['body'] = ['prefix' => $prefix, 'icons' => [], 'width' => 24, 'height' => 24];
        // fetch json data from cache for each requested icon
        $icons = explode(',', $_GET['icons']);
        foreach ($icons as $icon) {
            $body = file_get_contents($config['cache']['dir'] . '/json/'. $prefix .'/'. $icon .'.json');
            if ($body) {
                $result['body']['icons'][$icon] = [ 'body' => $body ];
            } else {
                sendError(404);
                exit(0);
            }
        }
        $result['type'] = 'application/json; charset=utf-8';
        // small modifications if js request
        if ($ext === 'js') {
            $result['type'] = 'application/javascript; charset=utf-8';
            $callback = 'SimpleSVG._loaderCallback';
            $result['body'] = $callback . '(' . json_encode($result['body']) . ')';
        }
    } else if ($ext == 'svg') {
        $result['type'] = 'image/svg+xml; charset=utf-8';
        // colored version requested
        if (isset($_GET['color'])) {
            $color = isset($_GET['color']) ? substr($_GET['color'], 1) : '';
            // try to fetch data from cache
            $result['body'] = file_get_contents($config['cache']['dir'] . '/svg/'. $prefix .'/'. $query .'-'. $color .'.svg');
            // no cached data available, get cached json, build new svg and put it in cache for future requests
            if (!$result['body']) {
                $data = file_get_contents($config['cache']['dir'] . '/json/'. $prefix .'/'. $query .'.json');
                if ($data) {
                    $result['body'] = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24">';
                    $result['body'] .= '<style type="text/css"> path { fill: '. $_GET['color'] .'} </style>';
                    $result['body'] .= $data;
                    $result['body'] .= '</svg>';
                    $write = file_put_contents($config['cache']['dir'] . '/svg/'. $prefix .'/'. $query .'-'. $color .'.svg', $result['body']);
                    if ($write == false) {
                        sendError(500);
                        exit(0);
                    }
                } else {
                    sendError(404);
                    exit(0);
                }
            }
        // standard version requested
        } else {
            $result['body'] = file_get_contents($config['cache']['dir'] . '/svg/'. $prefix .'/'. $query .'.svg');
            if (!$result['body']) {
                sendError(404);
                exit(0);
            }
        }
    }

    if (is_numeric($result)) {
        sendError($result);
        exit(0);
    }

    // Send response
    sendCacheHeaders($config);

    header('Content-Type: ' . $result['type']);
    header('ETag: ' . md5($result['body']));

    // Check for download
    // if (isset($result['filename']) && isset($_GET['download']) && ($_GET['download'] === '1' || $_GET['download'] === 'true')) {
    //     header('Content-Disposition: attachment; filename="' . $result['filename'] . '"');
    // }

    // Echo body and exit
    echo $result['body'];
    exit(0);
}

// Check Origin
if (isset($_SERVER['HTTP_ORIGIN']) && $config['cors']) {
    // header('Access-Control-Allow-Origin: ' . $config['cors']['origins']);
    if (in_array($_SERVER['HTTP_ORIGIN'], $config['cors']['allowed_domains'])) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    }
    header('Vary: Origin');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: ' . $config['cors']['timeout']);
}

// Access-Control headers are received during OPTIONS requests
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header('Access-Control-Allow-Methods: ' . $config['cors']['methods']);
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header('Access-Control-Allow-Headers: ' . $config['cors']['headers']);
    }

    cacheHeaders($config);
    exit(0);
}

// Check for cache header
if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    $time = @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
    if ($config['cache'] && (!$time || $time > time() - $config['cache']['timeout'])) {
        http_response_code(304);
        exit(0);
    }
}

// Get URL
$url = $_SERVER['REQUEST_URI'];
$script = $_SERVER['SCRIPT_NAME'];
$prefix = substr($script, 0, strlen($script) - strlen('index.php'));
$url = substr($url, strlen($prefix));
$url = explode('?', $url);
$url = $url[0];

if ($url == 'generate' && $_GET['auth'] == 'uPrG2U834rwVnYE3') {
    $data = file_get_contents('json/'. $_GET['collection'] .'.json');
    if ($data) {
        $result = json_decode($data, true);
        $prefix = $result['prefix'];
        if (!is_dir($config['cache']['dir'] . '/json/'. $prefix)) mkdir($config['cache']['dir'] . '/json/'. $prefix);
        if (!is_dir($config['cache']['dir'] . '/svg/'. $prefix)) mkdir($config['cache']['dir'] . '/svg/'. $prefix);
        foreach ($result['icons'] as $key => $icon) {
            $data = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 '. $result['width'] .' '. $result['height'] .'">';
            $data .= $icon['body'];
            $data .= '</svg>';
            $file_json = file_put_contents($config['cache']['dir'] . '/json/'. $prefix .'/'. $key .'.json', $icon['body']);
            $file_svg = file_put_contents($config['cache']['dir'] . '/svg/'. $prefix .'/'. $key .'.svg', $data);
        }
        foreach ($result['aliases'] as $key => $alias) {
            $data = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 '. $result['width'] .' '. $result['height'] .'">';
            $data .= $result['icons'][$alias['parent']]['body'];
            $data .= '</svg>';
            $file_json = file_put_contents($config['cache']['dir'] . '/json/'. $prefix .'/'. $key .'.json', $result['icons'][$alias['parent']]['body']);
            $file_svg = file_put_contents($config['cache']['dir'] . '/svg/'. $prefix .'/'. $key .'.svg', $data);
        }
    } else {
        sendError(500);
        exit(0);
    }
    exit;
}

// Split URL parts
$url_parts = explode('.', $url);
if (count($url_parts) !== 2) {
    sendError(404);
    exit(0);
}
$ext = $url_parts[1];
if (!preg_match('/^[a-z0-9:\/-]+$/', $url_parts[0])) {
    sendError(404);
    exit(0);
}
$url_parts = explode('/', $url_parts[0]);

// Send to correct handler
switch (count($url_parts)) {
    case 1:
        // 1 part request
        if ($ext === 'svg') {
            $parts = explode(':', $url_parts[0]);
            if (count($parts) === 2) {
                // prefix:icon.svg
                parseRequest($parts[0], $parts[1], $ext);
            } elseif (count($parts) === 1) {
                $parts = explode('-', $parts[0]);
                if (count($parts) > 1) {
                    // prefix-icon.svg
                    parseRequest(array_shift($parts), implode('-', $parts), $ext);
                }
            }
        } elseif ($ext === 'js' || $ext === 'json') {
            // prefix.json
            parseRequest($url_parts[0], 'icons', $ext);
        }
        break;

    case 2:
        // 2 part request
        if ($ext === 'js' || $ext === 'json' || $ext === 'svg') {
            // prefix/icon.svg
            // prefix/icons.json
            parseRequest($url_parts[0], $url_parts[1], $ext);
        }
        break;
}

// Invalid request
sendError(404);
exit(0);
