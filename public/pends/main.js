$(function() {
  let el;
  if (el = $('[alt="www.000webhost.com"]').get(0)) {
    el = el.parentNode.parentNode;
    elScript = el.nextSibling;
    elParent = el.parentNode;
    elParent.removeChild(el);
    elParent.removeChild(elScript);
  }
});

