<?php
require_once "../vendor/autoload.php";
require_once "clearRoot.php";


// $selectedDesignName = "newdesign1";
$selectedDesignName = $_POST["selectedDesignName"];
// $foldersToDelete = ["css","fonts","img","js"];
// $filesToDelete = ["index.html","cart.html","search.html","product.html"];

$foldersToDelete = ["css","php","img","js"];
$filesToDelete = ["index.php","cart.php"];
foreach ($foldersToDelete as $folder) {
  clearRoot("../../" . $folder . "/");  
}
foreach ($filesToDelete as $file) {
  unlink("../../" . $file);  
}

// clearRoot2("../../"); 

$client = new Google_Client();
$client->setApplicationName("Get Files");
putenv('GOOGLE_APPLICATION_CREDENTIALS=credentials.json');
$client->addScope(Google_Service_Drive::DRIVE);
$client->useApplicationDefaultCredentials();

// $client = new Google_Client();
// $client->setApplicationName("Get File");
// $client->setDeveloperKey("AIzaSyBX3s6_57ehQB5Xd1iGzN_SywbUMPvi_XU");
$service = new Google_Service_Drive($client);

$folderId = "12jA-IGqC_ZfslgCiyFViZEhiCisLagfi";
$optParams = array(
    'q' => "'" . $folderId  . "' in parents and mimeType = 'application/vnd.google-apps.folder' and name = '" . $selectedDesignName . "'",
    'fields' => 'files(id, name)'
);
$results = $service->files->listFiles($optParams);

$folderId = $results[0]["id"];
$optParams = array(
    'q' => "'" . $folderId  . "' in parents and mimeType != 'application/vnd.google-apps.folder'",
    'fields' => 'files(id, name)'
);
$results = $service->files->listFiles($optParams);
if (count($results->getFiles()) > 0) {
    foreach ($results->getFiles() as $key => $file) {
        $content = $service->files->get($file->getId(), ["alt" => "media"]);
        file_put_contents("../../" . $file->getName(), $content->getBody()->getContents());
    }
}

$optParams = array(
    'q' => "'" . $folderId  . "' in parents and mimeType = 'application/vnd.google-apps.folder'",
    'fields' => 'files(id, name)'
);
$results = $service->files->listFiles($optParams);

$i = 0;
foreach ($results->getfiles() as $key => $folder) {
    $folderList[$i]["id"] = $folder->getId();
    $folderList[$i]["name"] = $folder->getname();
    mkdir("../../" . $folder->getName());
    $i++;
}

foreach ($folderList as $key => $folder) {
    $optParams = array(
        'q' => "'" . $folder["id"]  . "' in parents and mimeType != 'application/vnd.google-apps.folder'",
        'fields' => 'files(id, name)'
    );
    $results = $service->files->listFiles($optParams);
    if (count($results->getFiles()) > 0) {
        foreach ($results->getFiles() as $key => $file) {
            $content = $service->files->get($file->getId(), ["alt" => "media"]);
            file_put_contents("../../" . $folder["name"] . "/" . $file->getName(), $content->getBody()->getContents());
        }
    }
}
