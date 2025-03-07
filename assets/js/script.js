
// Print PDF
printPdf = function (url) {
    var iframe = this._printIframe;
    if (!this._printIframe) {
      iframe = this._printIframe = document.createElement('iframe');
      document.body.appendChild(iframe);
  
      iframe.style.display = 'none';
      iframe.onload = function() {
        setTimeout(function() {
          iframe.focus();
          iframe.contentWindow.print();
        }, 1);
      };
    }
    
    iframe.src = '/includes' + url;
};