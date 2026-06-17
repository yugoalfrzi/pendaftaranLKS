<?php

namespace App\Http\Controllers\Concerns;

trait ExcelExportTrait
{
    /**
     * Build SpreadsheetML XML — menghasilkan .xls yang dibuka Excel sebagai tabel rapih
     * dengan header berwarna biru, border tipis, dan auto-width kolom.
     */
    protected function buildExcelXml(string $title, string $subtitle, array $headers, array $rows): string
    {
        $colCount   = count($headers);
        $totalBaris = count($rows);
        $tanggal    = date('d-m-Y H:i');

        // Helper: escape XML characters
        $esc = fn($v) => htmlspecialchars((string) $v, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        // Tentukan tipe data tiap kolom (numerik = kolom index 7 ke atas kecuali terakhir 3)
        $isNumeric = fn(int $colIdx) => $colIdx >= 7 && $colIdx < ($colCount - 3);

        // --- Build rows XML ---
        $rowsXml = '';

        // Baris 1: judul utama (merge semua kolom)
        $rowsXml .= "<Row ss:Height=\"24\"><Cell ss:MergeAcross=\"" . ($colCount - 1) . "\" ss:StyleID=\"sTitle\"><Data ss:Type=\"String\">{$esc($title)}</Data></Cell></Row>\n";

        // Baris 2: subjudul
        $rowsXml .= "<Row ss:Height=\"18\"><Cell ss:MergeAcross=\"" . ($colCount - 1) . "\" ss:StyleID=\"sSubtitle\"><Data ss:Type=\"String\">{$esc($subtitle)}</Data></Cell></Row>\n";

        // Baris 3: info tanggal & total
        $info = "Tanggal Export: {$tanggal}  |  Total Data: {$totalBaris} records";
        $rowsXml .= "<Row ss:Height=\"16\"><Cell ss:MergeAcross=\"" . ($colCount - 1) . "\" ss:StyleID=\"sInfo\"><Data ss:Type=\"String\">{$esc($info)}</Data></Cell></Row>\n";

        // Baris 4: kosong
        $rowsXml .= "<Row ss:Height=\"8\"></Row>\n";

        // Baris 5: header kolom
        $rowsXml .= "<Row ss:Height=\"36\">";
        foreach ($headers as $h) {
            $rowsXml .= "<Cell ss:StyleID=\"sHeader\"><Data ss:Type=\"String\">{$esc($h)}</Data></Cell>";
        }
        $rowsXml .= "</Row>\n";

        // Baris data
        foreach ($rows as $rowIdx => $row) {
            $style   = $rowIdx % 2 === 0 ? 'sRow' : 'sRowAlt';
            $rowsXml .= "<Row ss:Height=\"18\">";
            foreach ($row as $colIdx => $val) {
                if ($isNumeric($colIdx) && is_numeric($val)) {
                    $rowsXml .= "<Cell ss:StyleID=\"{$style}Num\"><Data ss:Type=\"Number\">{$val}</Data></Cell>";
                } else {
                    $rowsXml .= "<Cell ss:StyleID=\"{$style}\"><Data ss:Type=\"String\">{$esc($val)}</Data></Cell>";
                }
            }
            $rowsXml .= "</Row>\n";
        }

        // --- Column widths ---
        $colWidths = '';
        foreach ($headers as $idx => $h) {
            // Kolom teks lebar, kolom angka sempit
            $w = match(true) {
                $idx === 0  => 40,   // No
                $idx === 1  => 180,  // Nama Lembaga
                $idx === 3  => 130,  // Kab/Kota
                $idx === 4  => 150,  // Nama LKS
                $idx === 5  => 200,  // Alamat
                $idx === 6  => 120,  // Ketua
                $idx >= 7 && $idx < $colCount - 3 => 70, // angka
                $idx === $colCount - 3 => 100, // Telepon
                $idx === $colCount - 2 => 150, // Email
                $idx === $colCount - 1 => 110, // Tanggal
                default     => 90,
            };
            $colWidths .= "<Column ss:AutoFitWidth=\"0\" ss:Width=\"{$w}\"/>\n";
        }

        // --- Full XML ---
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<?mso-application progid="Excel.Sheet"?>' . "\n";
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        $xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        $xml .= ' xmlns:x="urn:schemas-microsoft-com:office:excel">' . "\n";

        // Styles
        $xml .= '<Styles>' . "\n";

        // Judul
        $xml .= '<Style ss:ID="sTitle"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="0"/>
            <Font ss:Bold="1" ss:Size="14" ss:Color="#1E3A5F"/>
            <Interior ss:Color="#D6E4F0" ss:Pattern="Solid"/>
            <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2" ss:Color="#1E3A5F"/></Borders>
        </Style>' . "\n";

        // Sub judul
        $xml .= '<Style ss:ID="sSubtitle"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Font ss:Bold="1" ss:Size="11" ss:Color="#2E5D8E"/>
            <Interior ss:Color="#EBF4FB" ss:Pattern="Solid"/>
        </Style>' . "\n";

        // Info
        $xml .= '<Style ss:ID="sInfo"><Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Font ss:Italic="1" ss:Size="9" ss:Color="#666666"/>
            <Interior ss:Color="#F5F5F5" ss:Pattern="Solid"/>
        </Style>' . "\n";

        // Header kolom
        $xml .= '<Style ss:ID="sHeader"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
            <Font ss:Bold="1" ss:Size="9" ss:Color="#FFFFFF"/>
            <Interior ss:Color="#1E5799" ss:Pattern="Solid"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF"/>
            </Borders>
        </Style>' . "\n";

        // Baris data putih
        $xml .= '<Style ss:ID="sRow"><Alignment ss:Vertical="Center" ss:WrapText="0"/>
            <Font ss:Size="9"/>
            <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D0D0"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D0D0"/>
            </Borders>
        </Style>' . "\n";

        // Baris data abu alternating
        $xml .= '<Style ss:ID="sRowAlt"><Alignment ss:Vertical="Center" ss:WrapText="0"/>
            <Font ss:Size="9"/>
            <Interior ss:Color="#EEF4FB" ss:Pattern="Solid"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0CEDC"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0CEDC"/>
            </Borders>
        </Style>' . "\n";

        // Angka putih
        $xml .= '<Style ss:ID="sRowNum"><Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
            <Font ss:Size="9"/>
            <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D0D0"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D0D0"/>
            </Borders>
        </Style>' . "\n";

        // Angka abu
        $xml .= '<Style ss:ID="sRowAltNum"><Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
            <Font ss:Size="9"/>
            <Interior ss:Color="#EEF4FB" ss:Pattern="Solid"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0CEDC"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0CEDC"/>
            </Borders>
        </Style>' . "\n";

        $xml .= '</Styles>' . "\n";

        // Worksheet
        $xml .= '<Worksheet ss:Name="Data">' . "\n";
        $xml .= '<Table>' . "\n";
        $xml .= $colWidths;
        $xml .= $rowsXml;
        $xml .= '</Table>' . "\n";

        // Freeze panes — bekukan header (5 baris judul + 1 header = baris ke-6)
        $xml .= '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
            <FreezePanes/>
            <FrozenNoSplit/>
            <SplitHorizontal>5</SplitHorizontal>
            <TopRowBottomPane>5</TopRowBottomPane>
            <ActivePane>2</ActivePane>
        </WorksheetOptions>' . "\n";

        $xml .= '</Worksheet>' . "\n";
        $xml .= '</Workbook>';

        return $xml;
    }
}
