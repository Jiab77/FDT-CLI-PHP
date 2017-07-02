<?php
// System vars
$web = (php_sapi_name() === 'cli' ? false : true);
$nl = ($web === false ? PHP_EOL : '<br>');

// Copy vars
$file = 'g4l-v0.53.iso';
$src = '/home/jiab77/Téléchargements/';
$dst = '/media/jiab77/NewData/';
$src_file = $src . $file;
$dst_file = $dst . $file;

// Check the destination
print($nl . "Check destination..." . $nl);
if (file_exists($dst_file)) {
	print("Deleting file..." . $nl);
	unlink($dst_file);
}

// Server start
print($nl . "Starting server..." . $nl);
$server = shell_exec('java -jar bin/fdt.jar -bs 4M >/dev/null 2>/dev/null &');
print("Waiting 1 seconds to let the server start..." . $nl);
sleep(1);
print("Started." . $nl);

// Client and copy start
print($nl . "Starting client and copy process..." . $nl);
$client = shell_exec('java -jar bin/fdt.jar -c localhost -d ' . $dst . ' ' . $src_file . ' 2>/dev/null &');

if (!is_null($client)) {
	echo ($web === true ? nl2br($client) : $client);
} else {
	print($nl . "Process failed." . $nl);
}

// Check destination again and give results
if (file_exists($dst_file)) {
	print("File copied!" . $nl);
} else {
	print("File not copied." . $nl);
}

// Kill the server
print($nl . "Killing server..." . $nl . $nl);
shell_exec('killall java');

// Process finished
