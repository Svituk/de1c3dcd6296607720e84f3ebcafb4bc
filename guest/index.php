<?


/////////////////////////////////////////
$title = 'Гостевая страница сайта';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
function guest_sanitize_html($html){
// Разрешаем теги Tiptap: p, strong, em, u, blockquote, a, br, b, i
$allowed = strip_tags($html,'<p><strong><em><u><blockquote><a><br><b><i>');
// Удаляем опасные атрибуты
$clean = preg_replace('/\s(on[a-z]+|style|class|id|data-[^=]+)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i','',$allowed);
// Очищаем ссылки - оставляем только href с http/https
$clean = preg_replace_callback('/<a[^>]*>([\s\S]*?)<\/a>/i',function($m){$href = '#';if(preg_match('/href\s*=\s*("|\')?(https?:\/\/[^"\'\s>]+)(\1)?/i',$m[0],$mm)){$href = $mm[2];}return '<a href="'.display_html($href).'" target="_blank" rel="noopener noreferrer">'.$m[1].'</a>';},$clean);
// Нормализуем теги: b -> strong, i -> em для совместимости
$clean = str_replace(['<b>','</b>'],['<strong>','</strong>'],$clean);
$clean = str_replace(['<i>','</i>'],['<em>','</em>'],$clean);
return $clean;
}
/////////////////////////////////////////
// Guard user access to avoid null offset warnings
$is_user = !empty($user);
$user_level = $is_user && isset($user['level']) ? intval($user['level']) : 0;

if ($user_level>0){
if (isset($_POST['txt'])){
if (!csrf_check()){
$err = '<div class="apicms_content"><center>Неверный CSRF-токен</center></div>';
}
$raw = isset($_POST['txt']) ? $_POST['txt'] : '';
// Проверяем длину текста без HTML тегов
$text_only = strip_tags($raw);
$len = mb_strlen($text_only, 'UTF-8');
if ($len>1024)$err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
if ($len<10)$err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
$hashtxt=str_replace(" ","", $text_only);
if(empty($hashtxt))$err = '<div class="apicms_content"><center>Ошибка ввода сообщения</center></div>';  
if (!isset($err)){
$text = guest_sanitize_html($raw);
// Проверяем длину после санитизации
$text_after_sanitize = strip_tags($text);
if (mb_strlen($text_after_sanitize, 'UTF-8') > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
if (mb_strlen($text_after_sanitize, 'UTF-8') < 10) $err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
}
    if (!isset($err)){
    global $connect;
    $safe_ip = mysqli_real_escape_string($connect, $ip);
    $dup = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`time`,`txt` FROM `guest` WHERE `ip` = '".$safe_ip."' ORDER BY `id` DESC LIMIT 1"));
    if ($dup && isset($dup['txt']) && $dup['txt'] === $text && ($time - intval($dup['time'])) <= 5){
        echo '<div class="erors">Сообщение успешно добавлено</div>';
    } else {
        $ins = mysqli_query($connect, "INSERT INTO `guest` (`txt`, `ip`, `time`, `browser`, `oc`, `adm`) VALUES ('$text', '".apicms_filter($ip)."', '$time', '".browser()."', '".apicms_filter($oc)."', '1')");
        if ($ins){
            echo '<div class="erors">Сообщение успешно добавлено</div>';
        } else {
            echo '<div class="apicms_content"><center>Ошибка записи сообщения</center></div>';
        }
    }
    } else {
    apicms_error($err);
    }
}
}
if (!$is_user){
if (isset($_POST['txt'])){
    if (!csrf_check()){
        $err = '<div class="apicms_content"><center>Неверный CSRF-токен</center></div>';
    }
    $raw = isset($_POST['txt']) ? $_POST['txt'] : '';
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    if ($code === '') $err = '<div class="apicms_content"><center>Вы не ввели проверочное число</center></div>';
    else if (!isset($_SESSION['captcha']) || $code != $_SESSION['captcha']) $err = '<div class="apicms_content"><center>Неверное проверочное число</center></div>';
// Проверяем длину текста без HTML тегов
$text_only = strip_tags($raw);
$len = mb_strlen($text_only, 'UTF-8');
if ($len>1024)$err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
if ($len<10)$err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
$hashtxt=str_replace(" ","", $text_only);
if(empty($hashtxt))$err = '<div class="apicms_content"><center>Ошибка ввода сообщения</center></div>';  
if (!isset($err)){
$text = guest_sanitize_html($raw);
// Проверяем длину после санитизации
$text_after_sanitize = strip_tags($text);
if (mb_strlen($text_after_sanitize, 'UTF-8') > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
if (mb_strlen($text_after_sanitize, 'UTF-8') < 10) $err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
}
    if (!isset($err)){
    global $connect;
    $safe_ip = mysqli_real_escape_string($connect, $ip);
    $dup = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`time`,`txt` FROM `guest` WHERE `ip` = '".$safe_ip."' ORDER BY `id` DESC LIMIT 1"));
    if ($dup && isset($dup['txt']) && $dup['txt'] === $text && ($time - intval($dup['time'])) <= 5){
        echo '<div class="erors">Сообщение успешно добавлено</div>';
    } else {
        $ins = mysqli_query($connect, "INSERT INTO `guest` (`txt`, `ip`, `time`, `browser`, `oc`, `adm`) VALUES ('$text', '".apicms_filter($ip)."', '$time', '".browser()."', '".apicms_filter($oc)."', '0')");
        if ($ins){
            echo '<div class="erors">Сообщение успешно добавлено</div>';
        } else {
            echo '<div class="apicms_content"><center>Ошибка записи сообщения</center></div>';
        }
    }
    } else {
    apicms_error($err);
    }
}
}

/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `guest`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'>Сообщений в гостевой не найдено</div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `guest` ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_guest = mysqli_fetch_assoc($qii)){
	// safe user id for guest posts (in case the field is missing/null)
	$post_guest_user_id = isset($post_guest['id_user']) ? intval($post_guest['id_user']) : 0;
	$ank2_result = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($post_guest_user_id)."' LIMIT 1");
	$ank2 = $ank2_result ? mysqli_fetch_assoc($ank2_result) : array('id' => 0, 'login' => 'Гость');
	echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center>';
if ($post_guest['adm']==1){
echo '<img src="/design/styles/'.display_html($api_design).'/guest/admin.png">';
}else{
echo '<img src="/design/styles/'.display_html($api_design).'/guest/user.png">';
}
echo "</center></td><td width='80%'> ";
if ($post_guest['adm']==1){
echo 'Статус: <font color="red"><b>Администрация сайта</b></font>';
}else{
echo 'Статус: <b>Гость сайта</b>';
}
echo "<span class='time-right'> ".apicms_data($post_guest['time'])." ";
if ($user_level>=1) echo ' | <a href="delete.php?id='.$post_guest['id'].'">DEL</a> ';
echo " </span>";
echo "</br>";
if ($user_level>=1)echo "<small> IP: ".display_html($post_guest['ip'])." / Браузер: ".display_html($post_guest['browser'])." / ОС: ".display_html($post_guest['oc'])."</small></br>";
$t = $post_guest['txt'];
// Проверяем, является ли текст HTML (содержит теги Tiptap)
if (preg_match('/<[a-z][\s\S]*>/i', $t)) {
    // Это HTML от Tiptap - очищаем и выводим
    $clean_html = guest_sanitize_html($t);
    echo " <div class='guest-message-content'>".apicms_smiles($clean_html)."</div></td></tr></table></div>";
} else if (strpos($t,'[')!==false){
    // Старый формат с BBCode
    echo " ".apicms_smiles(apicms_bb_code(apicms_br(display_html($t))))."</td></tr></table></div>";
} else {
    // Простой текст
    echo " ".apicms_smiles(display_html($t))."</td></tr></table></div>";
}
}
/////////////////////////////////////////
if ($user_level>0){
echo "<form action='?ok' method='post' class='guest-form'>";
echo "<div class='apicms_dialog'><center>";
echo "<div class='tiptap-toolbar' id='toolbar-user'></div>";
echo "<div class='ttarea-guest' id='editor-user' contenteditable='true'></div>";
echo "<input type='hidden' name='txt' id='txt-user'/>";
echo "<br />";
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
echo "<input type='submit' value='Добавить'/></center></div></form>";
}
if (!$is_user){
echo "<form action='?ok' method='post' class='guest-form'>";
echo "<div class='apicms_dialog'><center>";
echo "<div class='tiptap-toolbar' id='toolbar-guest'></div>";
echo "<div class='ttarea-guest' id='editor-guest' contenteditable='true'></div>";
echo "<input type='hidden' name='txt' id='txt-guest'/>";
echo "<br />";
echo '<img src="/captcha.php?'.rand(100, 999).'" width="50" height="27"  alt="captcha" />
<input name="code" type="text" maxlength="3" size="15" /><br/>';
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
echo "<input type='submit' value='Добавить'/></center></div></form>";
}
/////////////////////////////////////////
echo <<<'JS'
<script type="module">
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

function createToolbar(editor, toolbarId) {
  const toolbar = document.getElementById(toolbarId);
  if (!toolbar) return;
  
  toolbar.innerHTML = '';
  
  const buttons = [
    { cmd: 'bold', label: 'B', title: 'Жирный', type: 'mark' },
    { cmd: 'italic', label: 'I', title: 'Курсив', type: 'mark' },
    { cmd: 'blockquote', label: 'Цитата', title: 'Цитата', type: 'node' }
  ];
  
  buttons.forEach(btn => {
    const button = document.createElement('button');
    button.type = 'button';
    button.textContent = btn.label;
    button.title = btn.title;
    button.addEventListener('click', () => {
      if (btn.type === 'mark') {
        editor.chain().focus().toggleMark(btn.cmd).run();
      } else if (btn.type === 'node') {
        editor.chain().focus().toggleBlockquote().run();
      }
    });
    
    editor.on('selectionUpdate', () => {
      button.classList.toggle('is-active', editor.isActive(btn.cmd));
    });
    
    toolbar.appendChild(button);
  });
}

function initGuestTiptap() {
  const userEditor = document.getElementById('editor-user');
  const guestEditor = document.getElementById('editor-guest');
  
  if (userEditor && !userEditor.__tt) {
    try {
      userEditor.removeAttribute('contenteditable');
      const hiddenInput = document.getElementById('txt-user');
      const editor = new Editor({
        element: userEditor,
        extensions: [StarterKit.configure({
          heading: false,
          codeBlock: false,
          code: false,
          horizontalRule: false,
          strike: false,
        })],
        content: '',
        onUpdate: ({ editor }) => {
          if (hiddenInput) hiddenInput.value = editor.getHTML();
        },
      });
      createToolbar(editor, 'toolbar-user');
      const form = userEditor.closest('form');
      if (form) {
        form.addEventListener('submit', function() {
          if (hiddenInput) hiddenInput.value = editor.getHTML();
          const submitBtn = form.querySelector('input[type=submit]');
          if (submitBtn) submitBtn.disabled = true;
        });
      }
      userEditor.__tt = editor;
    } catch (e) {
      console.error('Error initializing user editor:', e);
    }
  }
  
  if (guestEditor && !guestEditor.__tt) {
    try {
      guestEditor.removeAttribute('contenteditable');
      const hiddenInput = document.getElementById('txt-guest');
      const editor = new Editor({
        element: guestEditor,
        extensions: [StarterKit.configure({
          heading: false,
          codeBlock: false,
          code: false,
          horizontalRule: false,
          strike: false,
        })],
        content: '',
        onUpdate: ({ editor }) => {
          if (hiddenInput) hiddenInput.value = editor.getHTML();
        },
      });
      createToolbar(editor, 'toolbar-guest');
      const form = guestEditor.closest('form');
      if (form) {
        form.addEventListener('submit', function() {
          if (hiddenInput) hiddenInput.value = editor.getHTML();
          const submitBtn = form.querySelector('input[type=submit]');
          if (submitBtn) submitBtn.disabled = true;
        });
      }
      guestEditor.__tt = editor;
    } catch (e) {
      console.error('Error initializing guest editor:', e);
    }
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initGuestTiptap);
} else {
  initGuestTiptap();
}
</script>
JS;
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
