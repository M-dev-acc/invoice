<?php
require "vendor/autoload.php";

function isValidValue($value) {
    return boolval($value);
}

function executeQuery($query) {
    $databaseServerName = "localhost";
    $databaseUsername = "root";
    $databasePassword = "";

    try {
        $databaseConnection = new PDO("mysql:host=$databaseServerName;dbname=invoice", $databaseUsername, $databasePassword);
        $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }

    $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $prepareStatement = $databaseConnection->prepare($query);
    $prepareStatement->execute();
    $prepareStatement->setFetchMode(PDO::FETCH_ASSOC);

    $dataCollection = $prepareStatement->fetchAll();

    return $dataCollection;
}

function generatePDF($content) {
    
    $mpdf = new \Mpdf\Mpdf();
    
    $mpdf->SetTitle("Document Title");
    $mpdf->WriteHTML($content);
   
    $mpdf->Output();
}


function getProductName($id) {
    $productDataCollection = executeQuery("SELECT name FROM products WHERE id=" . $id);

    return $productDataCollection[0]['name'];
}

if (isset($_POST)) {
    
    $filteredInvoiceQuantityInputs = array_values(array_filter($_POST['invoice_quantity'], 'isValidValue'));
    $filteredInvoicePriceInputs = array_values(array_filter($_POST['invoice_price'], 'isValidValue'));
    $filteredInvoiceTotalInputs = array_values(array_filter($_POST['invoice_total'], 'isValidValue'));

    $firmData = executeQuery("SELECT name, address FROM firms WHERE id=" . $_POST['firm']);
    $invoiceProductNames = $_POST['invoice_name'];

    // Generate PDF using the captured content

    $htmlContent = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice</title>
        
        <style>
            #firmInformation {
                float: left;
            }
            #vendorInformation {
                float: right;
            }

            #invoice {
                text-align: center;
            }

            #invoiceTable {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #ddd;
            }

            #invoiceTable th, #invoiceTable td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #bankInformation {
                float: left;
            }

            main.container {
                padding: 20px;
                margin: 0 auto;
                max-width: 800px; /* Adjust this as needed for your layout */
            }
        </style>

    </head>
    <body>
        <header>
            <nav></nav>
        </header>
        <main class="container">
            <div class="row" id="firmInformation">
                <div class="col-md-6">
                    <h3>Firm information</h3>
                    <strong>' .$firmData[0]['name'] . ' </strong>
                    <p>' . $firmData[0]['address'] .' </p>
                </div>
                
            </div>
            <div id="vendorInformation">
                <div class="col-md-6">
                    <h3>Send to</h3>
                    <p><strong>' . $_POST['vendor_name'] . '</strong></p>
                    <p><strong>' . $_POST['vendor_mobile_number'] .'</strong></p>
                    <p> ' . $_POST['vendor_address'] .'</p>
                </div>
            </div>
            <div class="row" id="invoice">
                
                <div class="col-md-12">
                    <table class="table table-bordered" id="invoiceTable">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>';
        for ($i = 0; $i < count($invoiceProductNames); $i++): 
            $htmlContent .= '<tr data-role="invoice-item-row" id="invoiceInputsRow">
                <td>
                    <span>'. getProductName($invoiceProductNames[$i]) .' </span>
                </td>
                <td>
                    <span>' . $filteredInvoiceQuantityInputs[$i] . '</span>
                </td>
                <td>
                    ' . $filteredInvoicePriceInputs[$i] . '
                </td>
                <td>
                        ' . $filteredInvoiceTotalInputs[$i] .'
                </td>
            </tr>';
        endfor;

    $htmlContent .= '
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
            </td>
            <td>
                <span>' . $_POST['invoice_subtotal'] . '</span>
            </td>
        </tr>
    </tfoot>
</table>
</div>
</div>

<div class="row mb-3" id="bankInformation">
<h3>Bank details</h3>
<p>
<strong>' . $_POST['bank_name'] . '</strong>
</p>
<p>' . $_POST['bank_branch_name'] . '</p>
<p>' . $_POST['bank_ifsc_number'] . '</p>
<p>' . $_POST['bank_account_number'] . '</p>
<p>' . $_POST['extra_note'] . '</p>

</div>
</main>
<footer></footer>

</body>
</html>';

generatePDF($htmlContent);

}

?>