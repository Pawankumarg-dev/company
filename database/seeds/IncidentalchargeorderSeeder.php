<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Incidentalpayment;
use App\Incidentalfee;

class IncidentalchargeorderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $details = array(
            array("order_number" => "INPUP05OR20220524023413MY2345", "ccavenue_referencenumber" => "111513562502", "bank_referencenumber" => "", "order_status" => "Aborted", "status_message" => "Transaction aborted by system.", "total_amount" => "4023.6", "actual_amount" => "4000", "transaction_fee" => "20", "service_fee" => "3.6", "payment_date" => "2022-05-24 14:34:34", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP05 for D.Ed.Spl.Ed.(CP) - 2018 (2 year)", "name" => "HAUSHILA PRASAD GIRI", "designation" => "HEAD FINANCE", "mobilenumber" => "9453218614", "email" => "FINANCE@KIRANVILLAGE.ORG", "reference_parameters" => "13,205,1872,6"),
            array("order_number" => "INPUP05OR20220524023737RK7550", "ccavenue_referencenumber" => "111513565748", "bank_referencenumber" => "550168022", "order_status" => "Shipped", "status_message" => "Payment Success", "total_amount" => "4024.6", "actual_amount" => "4000", "transaction_fee" => "20", "service_fee" => "3.6", "payment_date" => "2022-05-24 14:37:49", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP05 for D.Ed.Spl.Ed.(CP) - 2018 (2 year)", "name" => "HAUSHILA PRASAD GIRI", "designation" => "HEAD FINANCE", "mobilenumber" => "9453218614", "email" => "FINANCE@KIRANVILLAGE.ORG", "reference_parameters" => "13,205,1872,6"),
            array("order_number" => "INPUP05OR20220524024154ET8475", "ccavenue_referencenumber" => "111513570233", "bank_referencenumber" => "550168451", "order_status" => "Shipped", "status_message" => "Payment Success", "total_amount" => "4025.6", "actual_amount" => "4000", "transaction_fee" => "20", "service_fee" => "3.6", "payment_date" => "2022-05-24 14:42:05", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP05 for D.Ed.Spl.Ed.(CP) - 2018 (1 year)", "name" => "HAUSHILA PRASAD GIRI", "designation" => "HEAD FINANCE", "mobilenumber" => "9453218614", "email" => "FINANCE@KIRANVILLAGE.ORG", "reference_parameters" => "7,205,1872,6"),
            array("order_number" => "INPUP13OR20220524043102LK1991", "ccavenue_referencenumber" => "111513677810", "bank_referencenumber" => "", "order_status" => "Initiated", "status_message" => "", "total_amount" => "4026.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-24 16:31:44", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP13 for D.Ed.Spl.Ed.(MR) - 2018 (2 year)", "name" => "Ali Makin Naqvi", "designation" => "Director", "mobilenumber" => "8906026786", "email" => "ngvs2008@gmail.com", "reference_parameters" => "15,37,2308,6"),
            array("order_number" => "INPUP13OR20220524043102LK1991", "ccavenue_referencenumber" => "111513683962", "bank_referencenumber" => "", "order_status" => "Timeout", "status_message" => "Session Expired", "total_amount" => "4027.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-24 16:38:00", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP13 for D.Ed.Spl.Ed.(MR) - 2018 (2 year)", "name" => "Ali Makin Naqvi", "designation" => "Director", "mobilenumber" => "8906026786", "email" => "ngvs2008@gmail.com", "reference_parameters" => "15,37,2308,6"),
            array("order_number" => "INPUP13OR20220524044029FW3004", "ccavenue_referencenumber" => "111513687010", "bank_referencenumber" => "", "order_status" => "Initiated", "status_message" => "", "total_amount" => "4028.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-24 16:40:58", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP13 for D.Ed.Spl.Ed.(MR) - 2018 (2 year)", "name" => "Ali Makin Naqvi", "designation" => "Director", "mobilenumber" => "8906026786", "email" => "ngvs2008@gmail.com", "reference_parameters" => "15,37,2308,6"),
            array("order_number" => "INPUP13OR20220524044134ZD4874", "ccavenue_referencenumber" => "111513688021", "bank_referencenumber" => "214445609064", "order_status" => "Shipped", "status_message" => "Transaction Successful-NA-0", "total_amount" => "4029.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-24 16:42:00", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP13 for D.Ed.Spl.Ed.(MR) - 2018 (2 year)", "name" => "Ali Makin Naqvi", "designation" => "Director", "mobilenumber" => "8906026786", "email" => "ngvs2008@gmail.com", "reference_parameters" => "15,37,2308,6"),
            array("order_number" => "INPKE12OR20220525101902NN7141", "ccavenue_referencenumber" => "111514275149", "bank_referencenumber" => "214552545359", "order_status" => "Unsuccessful", "status_message" => "Initiated but Interval Time Out-NA-0", "total_amount" => "4030.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-25 10:21:16", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of KE12 for D.Ed.Spl.Ed.(IDD) - 2021 (1 year)", "name" => "sujatha", "designation" => "coordinator", "mobilenumber" => "09745115628", "email" => "sujathaputhur@gmail.com", "reference_parameters" => "54,69,3450,9"),
            array("order_number" => "INPKE12OR20220525102522QT6818", "ccavenue_referencenumber" => "111514280117", "bank_referencenumber" => "214552567018", "order_status" => "Shipped", "status_message" => "Initiated but Interval Time Out-NA-0", "total_amount" => "4031.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-25 10:25:42", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of KE12 for D.Ed.Spl.Ed.(IDD) - 2021 (1 year)", "name" => "sujatha", "designation" => "coordinator", "mobilenumber" => "09745115628", "email" => "sujathaputhur@gmail.com", "reference_parameters" => "54,69,3450,9"),
            array("order_number" => "INPKE12OR20220525103302UH5573", "ccavenue_referencenumber" => "111514288563", "bank_referencenumber" => "214552571593", "order_status" => "Shipped", "status_message" => "Initiated but Interval Time Out-NA-0", "total_amount" => "4032.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-25 10:33:15", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of KE12 for D.Ed.Spl.Ed.(IDD) - 2021 (2 year)", "name" => "sujatha", "designation" => "coordinator", "mobilenumber" => "09745115628", "email" => "sujathaputhur@gmail.com", "reference_parameters" => "55,69,3450,9"),
            array("order_number" => "INPRJ65OR20220525045928ZM1928", "ccavenue_referencenumber" => "111514708547", "bank_referencenumber" => "3661709545", "order_status" => "Shipped", "status_message" => "", "total_amount" => "4033.6", "actual_amount" => "8000", "transaction_fee" => "20", "service_fee" => "3.6", "payment_date" => "2022-05-25 17:00:26", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of RJ65 for D.Ed.Spl.Ed.(IDD) - 2021 (1 year)", "name" => "Dr. Satya Bhushan Nagar", "designation" => "Dean", "mobilenumber" => "9414291078", "email" => "drsbnagar@gmail.com", "reference_parameters" => "54,446,3587,9"),
            array("order_number" => "INPRJ59OR20220526095752KU7383", "ccavenue_referencenumber" => "111515227851", "bank_referencenumber" => "214625858574", "order_status" => "Shipped", "status_message" => "Transaction Successful-NA-0", "total_amount" => "4034.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-26 09:59:30", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of RJ59 for D.Ed.Spl.Ed.(IDD) - 2021 (1 year)", "name" => "MANOJ KUMAR", "designation" => "SUB.DIRECTOR", "mobilenumber" => "8955901777", "email" => "nayasawera77@gmail.com", "reference_parameters" => "54,438,3590,9"),
            array("order_number" => "INPRJ59OR20220526100530YH9147", "ccavenue_referencenumber" => "111515233940", "bank_referencenumber" => "214620212529", "order_status" => "Shipped", "status_message" => "Transaction Successful-NA-0", "total_amount" => "4035.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-26 10:05:55", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of RJ59 for D.Ed.Spl.Ed.(IDD) - 2021 (2 year)", "name" => "MANOJ KUMAR", "designation" => "SUB.DIRECTOR", "mobilenumber" => "8955901777", "email" => "nayasawera77@gmail.com", "reference_parameters" => "55,438,3590,9"),
            array("order_number" => "INPUP64OR20220526121326NT7869", "ccavenue_referencenumber" => "111515384392", "bank_referencenumber" => "214655017255", "order_status" => "Shipped", "status_message" => "Success-NA-0", "total_amount" => "4036.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-26 12:19:51", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UP64 for D.Ed.Spl.Ed.(ID) - 2020 (2 year)", "name" => "Gyanodaya Samekit Sansthan", "designation" => "Course Coordinator", "mobilenumber" => "8881461445", "email" => "Gyanodayaan@gmail.com", "reference_parameters" => "38,339,3162,8"),
            array("order_number" => "INPMN01OR20220526030510MN1922", "ccavenue_referencenumber" => "111515557316", "bank_referencenumber" => "214655398525", "order_status" => "Shipped", "status_message" => "Success-NA-0", "total_amount" => "4037.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-26 15:06:05", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of MN01 for D.Ed.Spl.Ed.(ID) - 2020 (2 year)", "name" => "Supriya Paul", "designation" => "Director", "mobilenumber" => "8014451237", "email" => "amhokeishamthong@gmail.com", "reference_parameters" => "38,168,3186,8"),
            array("order_number" => "INPJH09OR20220526081248OF2848", "ccavenue_referencenumber" => "111515847910", "bank_referencenumber" => "", "order_status" => "Initiated", "status_message" => "", "total_amount" => "4038.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-26 20:13:52", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of JH09 for D.Ed.Spl.Ed.(ID) - 2020 (2 year)", "name" => "GANESH GAURAV", "designation" => "COURSE CO-ORDINATOR", "mobilenumber" => "9934352294", "email" => "ganeshgauravisl@gmail.com", "reference_parameters" => "38,179,2873,8"),
            array("order_number" => "INPJH09OR20220526081248OF2848", "ccavenue_referencenumber" => "111515851045", "bank_referencenumber" => "214656062294", "order_status" => "Shipped", "status_message" => "Success-NA-0", "total_amount" => "4039.6", "actual_amount" => "8000", "transaction_fee" => "0", "service_fee" => "0", "payment_date" => "2022-05-26 20:17:34", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of JH09 for D.Ed.Spl.Ed.(ID) - 2020 (2 year)", "name" => "GANESH GAURAV", "designation" => "COURSE CO-ORDINATOR", "mobilenumber" => "9934352294", "email" => "ganeshgauravisl@gmail.com", "reference_parameters" => "38,179,2873,8"),
            array("order_number" => "INPUK01OR20220527113009OW1571", "ccavenue_referencenumber" => "111516274057", "bank_referencenumber" => "754179957991541", "order_status" => "Shipped", "status_message" => "Transaction is successfull", "total_amount" => "4040.6", "actual_amount" => "8000", "transaction_fee" => "20", "service_fee" => "3.6", "payment_date" => "2022-05-27 11:32:00", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UK01 for D.Ed.Spl.Ed.(ID) - 2020 (2 year)", "name" => "NIKITA RASTOGI", "designation" => "ACCOUNTS OFFICER", "mobilenumber" => "9897008878", "email" => "raphaelcentre@gmail.com", "reference_parameters" => "38,106,2887,8"),
            array("order_number" => "INPUK01OR20220527113818WY9740", "ccavenue_referencenumber" => "111516281790", "bank_referencenumber" => "", "order_status" => "Awaited", "status_message" => "", "total_amount" => "4041.6", "actual_amount" => "8000", "transaction_fee" => "20", "service_fee" => "3.6", "payment_date" => "2022-05-27 11:38:40", "payment_remarks" => "Incidental Charge", "transaction_remarks" => "Incidental Charges Payment of UK01 for D.Ed.Spl.Ed.(ID) - 2020 (2 year)", "name" => "NIKITA RASTOGI", "designation" => "ACCOUNTS OFFICER", "mobilenumber" => "9897008878", "email" => "raphaelcentre@gmail.com", "reference_parameters" => "38,106,2887,8"),
        );

        foreach ($details as $detail) {
            $order = Order::where('order_number', $detail["order_number"])->first();

            $bank_referencenumber = null;
            if(!is_null($bank_referencenumber) || $bank_referencenumber != "")
                $bank_referencenumber = trim($detail["bank_referencenumber"]);

            $order_status = "";
            if ($detail["order_status"] == "Shipped" || $detail["order_status"] == "Success") {
                $order_status = "Success";
            }
            elseif ($detail["order_status"] == "Failure" || $detail["order_status"] == "Unsuccessful") {
                $order_status = "Unsuccess";
            }
            else {
                $order_status = trim($detail["order_status"]);
            }

            $status_message = null;
            if(!is_null($status_message) || $status_message != "")
                $status_message = trim($detail["status_message"]);

            if (is_null($order)) {
                $order = Order::create([
                    "order_number" => $detail["order_number"],
                    "ccavenue_referencenumber" => trim($detail["ccavenue_referencenumber"]),
                    "bank_referencenumber" => $bank_referencenumber,
                    "order_status" => $order_status,
                    "status_message" => $status_message,
                    "total_amount" => trim($detail["total_amount"]),
                    "actual_amount" => trim($detail["actual_amount"]),
                    "transaction_fee" => trim($detail["transaction_fee"]),
                    "service_fee" => trim($detail["service_fee"]),
                    "payment_date" => trim($detail["payment_date"]),
                    "payment_remarks" => trim($detail["payment_remarks"]),
                    "transaction_remarks" => trim($detail["transaction_remarks"]),
                    "created_at" => trim($detail["payment_date"]),
                    "reference_parameters" => trim($detail["reference_parameters"])
                ]);
            }
            else {
                $order->update([
                    "ccavenue_referencenumber" => trim($detail["ccavenue_referencenumber"]),
                    "bank_referencenumber" => $bank_referencenumber,
                    "order_status" => $order_status,
                    "status_message" => $status_message,
                    "total_amount" => trim($detail["total_amount"]),
                    "actual_amount" => trim($detail["actual_amount"]),
                    "transaction_fee" => trim($detail["transaction_fee"]),
                    "service_fee" => trim($detail["service_fee"]),
                    "payment_date" => trim($detail["payment_date"]),
                    "payment_remarks" => trim($detail["payment_remarks"]),
                    "transaction_remarks" => trim($detail["transaction_remarks"]),
                    "created_at" => trim($detail["payment_date"]),
                    "reference_parameters" => trim($detail["reference_parameters"])
                ]);
            }

            $order_data = explode(',', $detail["reference_parameters"]);

            $incidentalfee_id = $order_data[0];
            $institute_id = $order_data[1];
            $approvedprogramme_id = $order_data[2];

            unset($order_data);

            /*
            $incidentalpayments = Incidentalpayment::where('incidentalfee_id', $incidentalfee_id)->where('institute_id', $institute_id)
                ->where('approvedprogramme_id', $approvedprogramme_id)->where('payment_mode', 'Online')->get();
            */
            $incidentalpayment = Incidentalpayment::where('order_id', $order->id)->first();

            if(is_null($incidentalpayment)) {
                Incidentalpayment::create([
                    "incidentalfee_id" => $incidentalfee_id,
                    "institute_id" => $institute_id,
                    "approvedprogramme_id" => $approvedprogramme_id,
                    "order_id" => $order->id,
                    "payment_mode" => "Online",
                    "paymenttype_id" => "4",
                    "paymentbank_id" => "225",
                    "payment_date" => $order->payment_date->format('Y-m-d'),
                    "payment_number" => $order->order_number,
                    "status_id" => 6,
                    'reference_number' => $order->order_number,
                    'amount_paid' => $order->actual_amount,
                    'name' => trim($detail["name"]),
                    'designation' => trim($detail["designation"]),
                    'mobilenumber' => trim($detail["mobilenumber"]),
                    'email' => trim($detail["email"])
                ]);
            }
        }
    }
}
