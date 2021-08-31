function print() {
  win = window.open();
  self.focus();
  win.document.open();
  win.document.write(`
    <!DOCTYPE html>
    <html lang = "en" dir = "ltr" >
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/print.css" rel="stylesheet" type="text/css">
    </head>
    <body>`);
  if (id == "fancybox-inner") {
    win.document.write($('.' + id).html());
  } else {
    win.document.write('<div id="' + id + '">' + $('#' + id).html() + '</div>');
  }
  win.document.write('</body></html>');
  win.document.close();
}