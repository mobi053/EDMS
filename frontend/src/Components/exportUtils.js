import * as XLSX from 'xlsx';
import { jsPDF } from 'jspdf';
import 'jspdf-autotable';

/**
 * Generic export utility for Excel and PDF
 * @param {string} type - Export type ('Excel' or 'Pdf')
 * @param {Array} data - Data to export
 * @param {Array} columns - Columns to export (header names)
 * @param {string} fileName - Name of the output file (default: 'export_data')
 */
export const triggerExport = (type, data, columns, fileName = "export_data") => {
    console.log("HEYYYYYYYYYYYY", type);
  if (type === 'Excel') {
    const filteredData = data.map(item => {
        const rowData = {};
        columns.forEach(col => {
          rowData[col.field] = item[col.field]; // Include only the specified columns
        });
        return rowData;
      });
      const worksheet = XLSX.utils.json_to_sheet(filteredData); // Convert filtered data to sheet format
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
      
      // Generate an Excel file and trigger download
      XLSX.writeFile(workbook, `${fileName}.xlsx`);
  } else if (type === 'Pdf') {
    // console.log("Columns:", columns); // Debugging log
    console.log("Data:", data); // Debugging log

    if (!columns || columns.length === 0) {
        console.error("No columns defined for PDF export");
        return;
    }
    const doc = new jsPDF(); // Create a new PDF document instance
    const tableRows = [];

    // Prepare table rows based on filtered data
    data.forEach(item => {
      const rowData = columns.map(col => item[col.field]); // Extract column values based on field
      tableRows.push(rowData);
    });

    // Add the table to the PDF document
    doc.autoTable({
      head: [columns.map(col => col.headerName)], // Header names
      body: tableRows,
      startY: 20,
    });

    // Add title to the PDF
    doc.text(`${fileName}`, 14, 15);

    // Save the generated PDF
    doc.save(`${fileName}.pdf`);
  }
};
