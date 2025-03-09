
// Print PDF
function printPDF(url) {
  const { jsPDF } = window.jspdf;

  // html2canvas(document.getElementById("content")).then(canvas => {
  //     const imgData = canvas.toDataURL("image/png");
  //     const pdf = new jsPDF();
  //     pdf.addImage(imgData, "PNG", 10, 10, 180, 160);
  //     pdf.save("export.pdf");
  // });

  html2canvas(document.body).then(canvas => {
    const imgData = canvas.toDataURL("image/png");
    const pdf = new jsPDF();
    pdf.addImage(imgData, "PNG", 10, 10, 180, 160);
    pdf.save("export.pdf");
  });
}