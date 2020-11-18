

<?php
require 'vendor/autoload.php';
use Carbon\Carbon;
use Carbon\CarbonInterval;
require_once ".serv/DataManager.php";


$sender = $_REQUEST['user_id'];
//exit;

if($_REQUEST['type'] == "messages") {
    $receiver = $_REQUEST['receiver'];//var_dump($messages);
    $messages = DataManager::query('messages','*',"(sender=$sender AND receiver=$receiver) or (receiver=$sender AND sender=$receiver)");
    DataManager::update('messages',["seen"=>"yes"],"(receiver=$sender AND sender=$receiver)");
    foreach ($messages as $message) {
        $senderName = DataManager::query("prelude_userprofiles", "*", "id={$message->sender}")[0]->name;
        $class = "";
        if ($message->sender == $sender) {
            $class = "right";
        }
        ?>
      <li class="<?php echo $class; ?>">
        <div class="conversation-list">
          <div class="chat-avatar">
            <x-make-avatar name="<?php echo $senderName; ?>" width="60" height="60"
                           cssClass="rounded-circle avatar-xs"/>
          </div>

          <div class="user-chat-content">
            <div class="ctext-wrap">
              <div class="ctext-wrap-content">
                <p class="mb-0">
                    <?php echo $message->message; ?>
                </p>
                <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span
                      class="align-middle"><?php echo Carbon::parse($message->created_at)->diffForHumans(); ?></span>
                </p>
              </div>

            </div>
            <div class="conversation-name" style="color:#acacac;"><i><?php echo $senderName; ?></i></div>
          </div>
        </div>
      </li>
    <?php }
}
?>


<?
if($_REQUEST['type'] == "chatlist") {
  $sql = "SELECT prelude_userprofiles.*, messages.message, messages.sender as sender, messages.created_at as message_time FROM messages JOIN prelude_userprofiles ON (prelude_userprofiles.id=messages.sender OR receiver=prelude_userprofiles.id) WHERE (sender=$sender OR receiver=$sender) AND prelude_userprofiles.id <> $sender ORDER BY messages.created_at DESC";
     $chatlists = DataManager::rawQuery($sql);

    $mainlist = [];
    foreach($chatlists as $list){
        $countMessagesObj = DataManager::query("messages","id","receiver=$sender AND sender =".$list->id ." AND seen='no'");
        $list->countMessages = count($countMessagesObj)?count($countMessagesObj):0;
        if($list->sender == $sender){
            $status = 1;
        }else{
            $status = 0;
        };
        $list->status = $status;
        if(!isset($mainlist["".$list->id]))
            $mainlist["".$list->id] = $list;
    }

    $chatlists = $mainlist;
//    print_r($chatlists);

     foreach ($chatlists as $list) { ?>
      <li class="unread">
        <a
            href="#"
            data-receiver="<?php echo $list->id; ?>"
            data-name="<?php echo $list->FirstName; ?>"
            data-company="<?php echo $list->Role.', ' . $list->CompanyName ;?>"
            class="chatuser"
        >
          <div class="media">

            <div class="chat-user-img online align-self-center mr-3">
              <img width="60" height="60" class="rounded-circle avatar-xs" src="https://ui-avatars.com/api/?name=<?php echo $list->FirstName; ?>&amp;color=153d77&amp;background=c5c0ff&amp;rounded=true" alt="IMG" />
              <!--<x-make-avatar name="<?php /*echo $list->FirstName; */?>" width="60" height="60"
                             cssClass="rounded-circle avatar-xs"/>-->
<!--              <span class="user-status"></span>-->
            </div>

            <div class="media-body overflow-hidden">
              <h5 class="text-truncate <!--font-size-15--> mb-1"><?php echo $list->FirstName; ?></h5>
              <p class="chat-user-message text-truncate mb-0"><i><span
                      class="<?php echo $list->status == 1 ? "ri-share-forward-fill" : ""; ?>"></span> <?php echo $list->message; ?>
                </i></p>
              <p class="chat-user-message text-truncate mb-0" style="color:#4b6cea;font-weight:bolder;">Company ~
                <i> <?php echo $list->CompanyName; ?></i></p>
            </div>
            <?php $date = Carbon::parse($list->message_time); ?>
            <div class="font-size-11"><?php echo $date->diffForHumans(); ?></div>
            <div class="unread-message">
              <?php if($list->countMessages){ ?>
              <span class="badge badge-soft-danger badge-pill"><?php echo $list->countMessages; ?></span>
              <?php } ?>
            </div>
          </div>
        </a>
      </li>
    <?php }

}

?>

<?php

if($_REQUEST['type'] == "search"){
    $user = DataManager::query('prelude_userprofiles','*',"id=$sender")[0];
    $userId = $user->id;
    $userRole = $user->Role;
    $userCompany = $user->CompanyName;
    $search = $_REQUEST['search'];
//        $search = $request->search;
    $prelude_userprofiles = DataManager::query("prelude_userprofiles",'*',"((Role = '$userRole' AND CompanyName = '$userCompany') OR (Role != '$userRole')) AND (CompanyName like '%$search%' OR FirstName like '%$search%') AND id != $userId");
foreach($prelude_userprofiles as $user){

?>
<li class="unread">
    <a
        href="#"
        data-receiver="<?php echo  $user->id  ;?>"
        data-name="<?php echo  $user->FirstName ;?>"
        data-company="<?php echo $user->Role.', ' . $user->CompanyName ;?>"
        class="chatuser"
    >
        <div class="media">

            <div class="chat-user-img online align-self-center mr-3">
                <img width="60" height="60" class="rounded-circle avatar-xs" src="https://ui-avatars.com/api/?name=<?php echo $user->FirstName; ?>&amp;color=153d77&amp;background=c5c0ff&amp;rounded=true" alt="IMG" />
<!--                <span class="user-status"></span>-->
            </div>

            <div class="media-body overflow-hidden">
                <h5 class="text-truncate font-size-15 mb-1"><?php echo $user->FirstName;?></h5>
                <p class="chat-user-message text-truncate mb-0"  style="color:#4b6cea;font-weight:bolder;">Company ~<i> <?php echo  $user->CompanyName ;?></i></p>
            </div>


        </div>
    </a>
</li>
<?php }
}

if($_REQUEST['type'] == "send") {
    $user = DataManager::query('prelude_userprofiles','*',"id=$sender")[0];
//    $sender = $user->id;
    $receiver = $_REQUEST['receiver'];
    $message = $_REQUEST['message'];

    DataManager::insert('messages',['sender','receiver','message'],[$sender,$receiver,$message]);

}
if($_REQUEST['type'] == "message-notification") {
    $user = DataManager::rawQuery("SELECT COUNT(id) AS count FROM messages WHERE receiver=$sender AND seen='no'");
    if(count($user)> 0){
      echo $user[0]->count;
    }else{
      echo 0;
    }
}


?>

