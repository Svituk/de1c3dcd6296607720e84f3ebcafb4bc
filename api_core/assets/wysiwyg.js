 (function(){
  function cmd(name, value){ document.execCommand(name, false, value); }
  function insertHTML(html){ document.execCommand('insertHTML', false, html); }
  function wrapHTML(before, after){
    var sel = window.getSelection();
    if (!sel || sel.rangeCount===0){ insertHTML(before+after); return; }
    var range = sel.getRangeAt(0); var content = range.toString(); insertHTML(before+content+after);
  }
  function youtubeEmbed(u){
    var m = u.match(/youtu\.be\/([A-Za-z0-9_-]{11})/i) || u.match(/[?&]v=([A-Za-z0-9_-]{11})/i) || u.match(/\/embed\/([A-Za-z0-9_-]{11})/i);
    var id = m?m[1]:''; if (!id) return '';
    return '<iframe src="https://www.youtube.com/embed/'+id+'" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
  }
  function makeToolbar(root, editor){
    var tb = root.querySelector('.wysiwyg-toolbar');
    function addButton(id,label,fn){ var b=document.createElement('button'); b.type='button'; b.id=id; b.textContent=label; b.onclick=fn; tb.appendChild(b); return b; }
    var bBold = addButton('w_b','B', function(){ cmd('bold'); });
    var bItal = addButton('w_i','I', function(){ cmd('italic'); });
    var bUnd = addButton('w_u','U', function(){ cmd('underline'); });
    var bStr = addButton('w_s','S', function(){ cmd('strikeThrough'); });
    var bBlk = addButton('w_q','Quote', function(){ wrapHTML('<blockquote>','</blockquote>'); });
    var bCode = addButton('w_code','Code', function(){ wrapHTML('<pre><code>','</code></pre>'); });
    var bUl = addButton('w_ul','• List', function(){ cmd('insertUnorderedList'); });
    var bOl = addButton('w_ol','1. List', function(){ cmd('insertOrderedList'); });
    var bLink = addButton('w_link','Link', function(){ var u=prompt('Ссылка'); if(u){ cmd('createLink', u); } });
    var bImg = addButton('w_img','Image', function(){ var u=prompt('Ссылка на изображение'); if(u){ insertHTML('<img src="'+u+'" alt="" style="max-width:100%;height:auto"/>'); } });
    var bVid = addButton('w_vid','Video', function(){ var u=prompt('Ссылка на видео (YouTube)'); if(u){ var h=youtubeEmbed(u); if(h){ insertHTML(h); } } });
    var color = document.createElement('input'); color.type='color'; color.id='w_color'; tb.appendChild(color);
    var bColor = addButton('w_color_apply','Color', function(){ var c=color.value||'#ff0000'; wrapHTML('<span style="color:'+c+'">','</span>'); });
    var bClr = addButton('w_clear','Clear', function(){ cmd('removeFormat'); });
    editor.addEventListener('keyup', function(){ var s=window.getSelection(); var active=function(cmd){ try{ return document.queryCommandState(cmd); }catch(e){ return false; } }; bBold.classList.toggle('is-active', active('bold')); bItal.classList.toggle('is-active', active('italic')); bUnd.classList.toggle('is-active', active('underline')); bStr.classList.toggle('is-active', active('strikeThrough')); });
  }
  window.apicmsWysiwyg = {
    init: function(opts){
      var ed = document.querySelector(opts.editor);
      var hidden = document.querySelector(opts.hidden);
      var form = ed ? ed.closest('form') : null;
      var root = ed ? ed.parentNode : null;
      if (!ed || !hidden || !root) return;
      makeToolbar(root, ed);
      if (form){ form.addEventListener('submit', function(){ hidden.value = ed.innerHTML; }); }
    }
  };
})();
