<?php

namespace App\Utils;

use TCPDF;

class CustomPDF extends TCPDF
{
    // Override the header to include watermark on each page
    public function Header()
    {
        $this->SetFont('helvetica', 'B', 50);
        $this->SetTextColor(255, 192, 203); // Pinkish color for watermark

        // Define the page dimensions
        $pageWidth = $this->getPageWidth();
        $pageHeight = $this->getPageHeight();

        // Calculate the center of the page
        $centerX = $pageWidth / 2;
        $centerY = $pageHeight / 2;

        // Apply rotation (45 degrees) centered around the center of the page
        $this->Rotate(45, $centerX, $centerY);

        // Place watermark text in the center of the page
        $this->Text($centerX - 70, $centerY, 'Watermark Text');  // Adjust the position to ensure it's centered and extends diagonally

        // Reset the rotation
        $this->Rotate(0);
    }

    // Optionally, override the footer if needed
    public function Footer()
    {
        // Footer content (like page numbers) can be added here if required
    }

    // Set the page size and orientation in AddPage
    public function setupPage()
    {
        // Define the paper size and orientation (A4, portrait)
        $this->AddPage('P', 'A4');  // 'P' stands for portrait, 'A4' is the page size
    }
}
