(function(){var e=document.getElementById("mail-main-nav");new SimpleBar(e,{autoHide:!0});var t=document.getElementById("mail-info-body");new SimpleBar(t,{autoHide:!0});var l=document.getElementById("mail-recepients");new SimpleBar(l,{autoHide:!0});var o=[[{header:[1,2,3,4,5,6,!1]}],[{font:[]}],["bold","italic","underline","strike"],["blockquote","code-block"],[{header:1},{header:2}],[{list:"ordered"},{list:"bullet"}],[{color:[]},{background:[]}],[{align:[]}],["image","video"],["clean"]];new Quill("#mail-reply-editor",{modules:{toolbar:o},theme:"snow"}),new Choices("#toMail",{allowHTML:!0,removeItemButton:!0})})();