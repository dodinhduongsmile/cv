<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
require __DIR__ . '/googleapi/vendor/autoload.php'; // Include Class File
use Google\Client;
use Google\Service\Drive;

class Google_api
{

    // public $redirect_uri;//truyền được ra controler gọi library,protected chỉ dùng ở trong class
    protected $client_id = GG_API;
    protected $client_secret = GG_SECRET;
    protected $redirect_uri = 'http://pducomputer.com/googleapp/file_drive';
    protected $scopes_drive = array('https://www.googleapis.com/auth/drive',);
    protected $scopes_auth = array('profile', 'email');
    protected $client;
    protected $service;
    /**
 * Returns an authorized API client.
 * @return Client the authorized client object
 */
public function service_account()
{
    /*
    chỉ get được file, không chia sẻ được. không hiểu
     */
    $KEY_FILE_LOCATION = __DIR__."/notional-sign-371008-63932f79a001.json";
    $client1 = new Client();
    // $client->setApplicationName("google drive");
    $client1->setAuthConfig($KEY_FILE_LOCATION);
    $client1->setAccessType('offline');
    $client1->setScopes($this->scopes_drive);

    $this->service = new Drive($client1);
    
}
public function service_account1()
{
$service = new Drive($this->client);
$optParams = array(
    'pageSize' => 999,//số file sẽ lấy, max 1000
    'orderBy' => 'name',
    'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents)",
    'q' => "'1CX9dFIjM5z-tILnSIA6DjtXPgMQVUVPr' in parents",
);
$results = $service->files->listFiles($optParams);
dd($results);
// $role = 'reader';//reader-chỉ đọc, writer- chỉnh sửa
//     $userEmail = 'lehongthaifb@gmail.com';
//     $fileId = '1CX9dFIjM5z-tILnSIA6DjtXPgMQVUVPr';

//     $userPermission = new Google_Service_Drive_Permission(array(
//       'type' => 'user',
//       'role' => $role,
//       'emailAddress' => $userEmail
//     ));

//     $request = $service->permissions->create(
//       $fileId, $userPermission, array('fields' => 'id')
//     );
//     return $request;
}
public function login($redirect_url,$scopes='',$refresh_token="")
{

/*
chức năng: đăng nhập google|| truy cập google drive
 */
/*
có 2 cách lấy Accesstoken
$client->fetchAccessTokenWithAuthCode($_GET['code']) = $client->authenticate($_GET['code']);
      => gọi Accesstoken ra $_SESSION['token'] = $client->getAccessToken();
 */
/*  
-phiên bản này thì sẽ không bị hết hạn token khi đang dùng vì có refresh_token
- có thể lưu refresh_token vào db, sau login tài khoản get refresh_token ra, rồi auto đăng nhập google ngầm
- refresh_token có là mã cố định, chỉ không dùng được khi xóa app || để 6 tháng k dùng
*/
    if($scopes == 'drive'){
        $scopess = $this->scopes_drive;
    }else{
        $scopess = $this->scopes_auth;
    }
        $gClient = new Client();
        $gClient->setClientId($this->client_id);
        $gClient->setClientSecret($this->client_secret);
        $gClient->setRedirectUri($redirect_url);

        $gClient->setAccessType('offline');//offline mỗi lần truy cập sẽ là mã mới->bắt buộc đăng nhập lại để lấu authcode new, default là online, có liên quan tới refresh_token, chưa hiểu lắm

        // $gClient->setApprovalPrompt('consent');//bật thông báo xác nhận
        // $gClient->setIncludeGrantedScopes(true);
        $gClient->setScopes($scopess);

    if(isset($_SESSION['GOOGLE_ACCESS_TOKEN'])){
        $gClient->setAccessToken($_SESSION['GOOGLE_ACCESS_TOKEN']);
    }
    try{
        if ($gClient->isAccessTokenExpired()) {//nếu chưa có mã token trước đó, hoặc đã hết hạn
            // Refresh the token if possible, else fetch a new one.
            // $refresh_token2 = "1//0ezSDjxWF9ZPJCgYIARAAGA4SNwF-L9IrciKy8FerA7kvahhnQQ7mq0iDuB1UPe9Ts9kyv-cYWcxkZETPUaNvT_xi8nGIyl7IsSI";

            if(empty($refresh_token)){
                //trống $refresh_token thì phải get đc $refresh_token mới từ user id = 1
                $ci =& get_instance();
                $ci->load->model('users_model');
                $_user = new Users_model();
                $user = $_user->getById(1,"id,refresh_token");
                $refresh_token1 = $user->refresh_token;

                $gClient->fetchAccessTokenWithRefreshToken($refresh_token1);
                //set access token new
                $_SESSION['GOOGLE_ACCESS_TOKEN'] = $gClient->getAccessToken();
                
                if(empty($_SESSION['GOOGLE_ACCESS_TOKEN'])){//nếu refresh_token hết hạn thì return null ->login lại
                    
                    $auth_url = $gClient->createAuthUrl(); 
                    $authCode =isset($_GET['code']) ? $_GET['code'] : "";
                    if (empty($authCode)) {
                        //rediect to login page
                        return redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
                    } else {
                        //lay token tu code
                        $accessToken = $gClient->fetchAccessTokenWithAuthCode($authCode);
                        $gClient->setAccessToken($accessToken);
                        if($scopes == 'drive'){
                            /*Lưu lại vì sau load lại đỡ gọi lại google*/
                           $_SESSION['GOOGLE_ACCESS_TOKEN'] = $accessToken;
                           /*update refresh_token to user*/
                           if(isset($_SESSION['GOOGLE_ACCESS_TOKEN']['refresh_token'])){
                                $refresh_up = $_SESSION['GOOGLE_ACCESS_TOKEN']['refresh_token'];
                                $_user->update(['id' => 1],['refresh_token'=>$refresh_up]);
                            }
                        }
                        // Check to see if there was an error.
                        if (array_key_exists('error', $accessToken)) {
                            throw new Exception(join(', ', $accessToken));
                        }
                        
                    }
                }
            }

        }
        
    }catch(Exception $e) {
        // TODO(developer) - handle error appropriately
        echo 'Some error occured: '.$e->getMessage();
    }
    $this->client = $gClient;
}


/*share file*/
public function sharefile($userEmail,$fileId,$sendNotification=true)
{
    $service = new Drive($this->client);

    $role = 'reader';//reader-chỉ đọc, writer- chỉnh sửa
    // $userEmail = 'lehongthaifb@gmail.com';
    // $fileId = '1CX9dFIjM5z-tILnSIA6DjtXPgMQVUVPr';

    $userPermission = new Google_Service_Drive_Permission(array(
      'type' => 'user',
      'role' => $role,
      'emailAddress' => $userEmail
    ));
//sendNotificationEmail : flase -> tắt thông báo khi share, default true
    $request = $service->permissions->create(
      $fileId, $userPermission, array('fields' => 'id',"sendNotificationEmail"=>$sendNotification)
    );
    return $request;
}
/*remove email share*/
public function remove_share($email,$fileId,$permissionId)
{
    $service = new Drive($this->client);
    // $fileId = "1CX9dFIjM5z-tILnSIA6DjtXPgMQVUVPr";
    
    if(!empty($permissionId)){
        $service->permissions->delete($fileId, $permissionId);
    }else{
        $permissions = $service->permissions->listPermissions($fileId,["fields"=>"*"]);
        foreach ($permissions['permissions'] as $permission) {
            if ($permission['emailAddress'] == $email) {
                $permissionId = $permission['id'];
                break;
            }
        }
    }
    return true;
    
}
/*
get info login
 */
public function getInfo_Google()
{
    $google_oauth = new \Google_Service_Oauth2($this->client);
    $userInfo = $google_oauth->userinfo->get();
    return $userInfo;
}
/**
 *   Check if the user is logged in or not
 */
public function isLogin()
{
    if (isset($_SESSION['GOOGLE_ACCESS_TOKEN'])) {
        return true;
    } else {
        return false;
    }
}
public function getClient()
{
    $client = new Client();
    // $client->setApplicationName('Google Drive API PHP Quickstart');
    // $client->setScopes('https://www.googleapis.com/auth/drive.metadata.readonly');
    // $client->setAuthConfig('credentials.json');
    // $client->setAccessType('offline');
    // $client->setPrompt('select_account consent');

    $client->setClientId("905435334446-60a7c0ikb1jm1anld477fqjeuos7duk7.apps.googleusercontent.com");
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost/ctytoan/pducomputer/googlex/test');
        $client->setAccessType('offline');
        $client->setScopes('https://www.googleapis.com/auth/drive');
    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    try{


        if ($client->isAccessTokenExpired()) {//nếu chưa có mã token trước đó, hoặc đã hết hạn
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = $_GET['code'];

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
    }
    catch(Exception $e) {
        // TODO(developer) - handle error appropriately
        echo 'Some error occured: '.$e->getMessage();
    }
    return $client;
}



public function getListFile($data)
{
    $x = [
        'foder' => [],
        'child' => [
            0 => "value",
            1=> [//là folder chương
                0 => "video",
                1 =>  "v2"
            ],
            2 => "v2"
        ]
    ];
    // Get the API client and construct the service object.
//. Get $service  cách 1: dùng khi login
$client = $this->client;
$service = new Drive($client);

//. Get $service  cách 2: dùng account service
// $service = $this->service;

    // Print the names and IDs for up to 10 files.
$folderId = $data['id_folder'];
//param truy vấn, cách viết q https://developers.google.com/drive/api/guides/search-files
//'fields' => "nextPageToken, files(contentHints/thumbnail,fileExtension,iconLink,id,name,size,thumbnailLink,webContentLink,webViewLink,mimeType,parents)",

$optParams = array(
    'pageSize' => 999,//số file sẽ lấy, max 1000
    'orderBy' => 'name',
    'fields' => "nextPageToken, files(id,name,mimeType)",
    'q' => "'".$folderId."' in parents",
);

$list_file = array();
$stt = 0;

    $folder_info = $service->files->get($folderId);
    $list_file['foder'] = [
        'id' => $folder_info->id,
        'name' => $folder_info->name
    ];
    $results = $service->files->listFiles($optParams);

    // print_r ($results['files']); //=$results->getFiles()

    if (count($results['files']) == 0) {
        print "No files found.\n";
    } else {
        // $list_file = $this->_recursive_childpdu($results['files'],$service,$optParams);
        foreach ($results['files'] as $file) {
            $stt++;
            $results_child1 = array();
            if($data['sub'] == 1){
                if($file['mimeType'] == 'application/vnd.google-apps.folder'){
                    $optParams['q'] = "'".$file->id."' in parents";
                    $child1 = $service->files->listFiles($optParams);
                    $results_child1 = $this->_recursive_childpdu($child1['files'],$service,$optParams);

                }
            }
            
            $list_file['child'][] =   array(
                'id' => $file->id,//=getId()
                'name' => $file->name,//=getName()
                'mimeType' => $file->mimeType,
                'child' => $results_child1
            );
            
        }

    }
// dd($list_file);
// echo "<pre>";
// print_r ($list_file);
// echo "<pre>";
return $list_file;
}


public function _recursive_childpdu($all,$service,$optParams){

    if(!empty($all)) foreach ($all as $key => $file){
        $this->category[]  = array(
                'id' => $file->id,//=getId()
                'name' => $file->name,//=getName()
                'mimeType' => $file->mimeType
            );

        if($file['mimeType'] == 'application/vnd.google-apps.folder'){
            $optParams['q'] = "'".$file->id."' in parents";
            $child1 = $service->files->listFiles($optParams);

            if(!empty($child1['files'])){
                $this->_recursive_childpdu($child1['files'],$service,$optParams);
            }
            
        }
        
    }
    return $this->category;
}

public function login2($redirect_url,$scopes='',$refresh_token="")
{
/*
chức năng: đăng nhập google|| truy cập google drive
 */
    if($scopes == 'drive'){
        $scopess = $this->scopes_drive;
    }else{
        $scopess = $this->scopes_auth;
    }
        $gClient = new Client();
        $gClient->setClientId($this->client_id);
        $gClient->setClientSecret($this->client_secret);
        $gClient->setRedirectUri($redirect_url);

        $gClient->setAccessType('offline');

        $gClient->setScopes($scopess);

    if(isset($_SESSION['GOOGLE_ACCESS_TOKEN'])){
        $gClient->setAccessToken($_SESSION['GOOGLE_ACCESS_TOKEN']);
    }
    try{
        if ($gClient->isAccessTokenExpired()) {//nếu chưa có mã token trước đó, hoặc đã hết hạn

            // Refresh the token if possible, else fetch a new one.
            if ($refresh_token) {
                $gClient->fetchAccessTokenWithRefreshToken($refresh_token);
                //set access token new
                $_SESSION['GOOGLE_ACCESS_TOKEN'] = $gClient->getAccessToken();
                
            } else {
                $auth_url = $gClient->createAuthUrl(); 
                $authCode =isset($_GET['code']) ? $_GET['code'] : "";
                if (empty($authCode)) {
                    //rediect to login page
                    return redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
                } else {

                    //lay token tu code
                    $accessToken = $gClient->fetchAccessTokenWithAuthCode($authCode);
                    $gClient->setAccessToken($accessToken);
                    if($scopes == 'drive'){
                        /*Lưu lại vì sau load lại đỡ gọi lại google*/
                       $_SESSION['GOOGLE_ACCESS_TOKEN'] = $accessToken;
                    }
                    // Check to see if there was an error.
                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }
                    
                }
                
            }
        }
        
    }catch(Exception $e) {
        echo 'Some error occured: '.$e->getMessage();
    }
    $this->client = $gClient;
}

}?>