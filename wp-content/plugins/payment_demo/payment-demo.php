<?php

/**
 * Plugin Name:       Payment Demo
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ashok
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       payment-demo
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PAYMENT_DEMO_VERSION', '1.0.0' );

function activate_payment_demo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-payment-demo-activator.php';
	Payment_Demo_Activator::activate();
}

function deactivate_payment_demo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-payment-demo-deactivator.php';
	Payment_Demo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_payment_demo' );
register_deactivation_hook( __FILE__, 'deactivate_payment_demo' );

require plugin_dir_path( __FILE__ ) . 'includes/class-payment-demo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_payment_demo() {

	$plugin = new Payment_Demo();
	$plugin->run();

}
run_payment_demo();


function payment_demo_shortcode(){
    global $wpdb; 
    $tbl_emi_details = $wpdb->prefix.'emi_details';

    $emi_details = $wpdb->get_results ( "SELECT * FROM $tbl_emi_details ");

    $frm_card = $frm_emi = $user_id = $emi_id = $alert = '';
    $product_id = 1;
    $total_amount = 50000;$purchase_amount = '50,000';
    $otp_show = 'hide';
    $main_tab = '';
    // Stop running function if form wasn't submitted
    if ( isset($_POST['frm_card']) ) {
        $payment_type = 'card';
        $main_tab = 'hide';
        $otp_show = '';
        $full_name = $_POST['full_name'];
        $card_number = $_POST['card_number'];
        $ex_month = $_POST['ex_month'];
        $ex_year = $_POST['ex_year'];
        $cvv = $_POST['cvv'];

        $wpdb->insert( 
            'm2p_user_details', 
            array(
                'full_name' => $full_name, 
                'card_number' => $card_number, 
                'expiry-month' => $ex_month,
                'expiry-year' => $ex_year,
                'cvv' => $cvv,
            )
        );
        $user_id = $wpdb->insert_id;
    }
    if ( isset($_POST['frm_emi']) ) {
        $payment_type = 'emi';
        $main_tab = 'hide';
        $otp_show = '';
        $emi_id = $emi_option = $_POST['emi-option'];
        //$emi_lender = $_POST['emi-lender'];
        $dob = $_POST['dob'];
        $pan = $_POST['pan'];
        $full_name = $_POST['f_name'];
        $mobile_no = $_POST['mobile_no'];

        $wpdb->insert( 
            'm2p_user_details', 
            array(
                'full_name' => $full_name, 
                'mobile_no' => $mobile_no, 
                'dob' => $dob, 
                'pan' => $pan
            )
        );
        $user_id = $wpdb->insert_id; 
    }
    if ( isset($_POST['frm_otp']) ) { 
        $main_tab = 'hide';
        $otp_show = '';
        $otp = $_POST['otp'];
        $user_id = $_POST['user_id'];
        $product_id = $_POST['product_id'];
        $emi_id = $_POST['emi_id'];
        $emi_detail = $wpdb->get_results ( "SELECT * FROM $tbl_emi_details WHERE emi_id=".$emi_id);
        if($emi_detail[0]) {
            $interest_amount = $total_amount * ($emi_detail[0]->emi_interest/100); 
            $emi_type_id = $emi_detail[0]->emi_type_id;
            if($emi_type_id == 2) {
                $total_amount = $total_amount + $interest_amount;
                $total_amount = number_format($total_amount,'2','.','');
                $deduction = "-";
            } else {
                $deduction = "-$interest_amount INR";
            }
                $interest = "$interest_amount INR";
            $emi_amount = $total_amount / $emi_detail[0]->emi_period;
            $emi_amount = number_format($emi_amount,'2','.','');
        }
        $payment_type = $_POST['payment_type'];
        $status = $payment_status = 'success';

        $wpdb->insert( 
            'm2p_user_otp_verify', 
            array(
                'user_id' => $user_id, 
                'otp' => $otp,
                'status' => $status,
            )
        );
        $wpdb->insert( 
            'm2p_payment_details', 
            array(
                'user_id' => $user_id,
                'product_id' => (int)$product_id, 
                'emi_id' => (int)$emi_id,
                'emi_amount' => $emi_amount,
                'total_amount' => $total_amount,
                'payment_type' => $payment_type,
                'payment_status' => $payment_status,
            )
        );
    }

	$content = '<div class="container "> <h1 style="text-align: center;">Make Payment</h1> <div class="tab2-container" style="padding: 30px 0 10px;border-bottom: 1px solid #ddd;"> <div class="row"> <div class="col-sm-3"> <div class="col-title">Purchase Amount</div> <div class="col-value purchase_amount">'.$purchase_amount.'</div> </div> <div class="col-sm-3"> <div class="col-title">Merchant Name</div> <div class="col-value">Electronics Store</div> </div> <div class="col-sm-3"> <div class="col-title">Customer Mobile Number</div> <div class="col-value">+91 0123456789</div> </div> <div class="col-sm-3"> <div class="col-title">Purchase Date</div> <div class="col-value">Apr 21, 2021</div> </div> </div> </div><div class="tabset '. $main_tab.'"><input type="radio" name="tabset" id="tab1" aria-controls="pay_on_card" checked> <label for="tab1">Pay with Card</label><input type="radio" name="tabset" id="tab2" aria-controls="pay_on_emi"> <label for="tab2">Pay@ease</label> <div class="tab-panels">'; 
    $content .= '<section id="pay_on_card" class="tab-panel"> <div class="row '. $frm_card.'" id="tab-1"> <div class="col-lg-6"> <form class="form" method="POST" id="frm_pay_on_card"> <div class="row"> <div class="col-lg-12 field"> <label>Full Name (as on card)*</label> <input id="full_name" name="full_name" type="text" class="form-control" placeholder=""> <span>Invalid Full Name!</span> </div> </div> <div class="row"> <div class="col-lg-12 field"> <label>Card Number</label> <input id="card_number" name="card_number" type="text" class="form-control" placeholder="XXXXXXXXXXXXXXXX"> <span>Invalid Card Number!</span> </div> </div> <div class="row"> <div class="col-sm-4 field"> <label>Expiry Date</label> <select id="ex_year" name="ex_year" class="form-control select-box" data-placeholder=""> <option>2022</option> <option>2023</option> <option>2024</option> <option>2025</option> </select> </div> <div class="col-sm-4 field"> <select id="ex_month" name="ex_month" class="form-control select-box"  style="margin-top: 26px"> <option>12</option> <option>11</option> <option>10</option> <option>09</option> </select> </div> <div class="col-sm-4 field"> <label>CVV</label> <input id="cvv" name="cvv" type="text" class="form-control" placeholder="XXX"> <span>Invalid CVV!</span> </div> </div>'. wp_nonce_field( 'wps-frontend-post' ).'<input name="frm_card" value="PayWithCard" type="hidden"> <div class="row"> <div class="col-lg-12"> <button class="btn " id="btn_pay_on_card" name="btn_pay_on_card">Pay Now</button> </div> </div> </form> </div> </div> </section>';
    $content .= '<section id="pay_on_emi" class="tab-panel "> <div class="row '. $frm_emi.'" id="tab-2"> <div class="col-lg-6" style="margin:auto" id="no_cost_emi"> <form class="form" method="POST" id="frm_emi_1"> <div class="emi-container" style=""> <div id="emi_stage_1"> <div class="tabset"><input type="radio" name="tabset" id="tab3" aria-controls="tb_no_cost_emi" checked> <label for="tab3">No Cost EMI</label><input type="radio" name="tabset" id="tab4" aria-controls="tb_std_emi"> <label for="tab4">Standard EMI</label> <div class="tab-panels"> <section id="tb_no_cost_emi" class="tab-panel"> <div class="emi-select-options pt-20"> <div>Select Your EMI Option</div> <div class="emi-options emi-options1 pt-10"> <div class="emi-option fill" data-emi-val="3" data-emi-opt="1">3M</div> <div class="emi-option" data-emi-val="6" data-emi-opt="1">6M</div> <div class="emi-option" data-emi-val="9" data-emi-opt="1">9M</div> <div class="emi-option" data-emi-val="12" data-emi-opt="1">12M</div> </div> <p class="has-error hide">Select any EMI Option!</p> </div> <div class="emi-select-lenders pt-20"> <div>Select Lender</div> <div class="emi-lenders-list emi-lenders-list1">';
    foreach($emi_details as $detail){
        if( $detail->emi_type_id == 1){
        $period = $detail->emi_period;
        $content.='<div class="emi-lender lender_'.$detail->emi_period.'" data-period="'.$detail->emi_period.'" data-interest="'.$detail->emi_interest.'" data-type="'.$detail->emi_type_id.'"> <div class="col-sm-1"> <input type="radio" name="emi-lender" id="lender_'.$detail->emi_id.'" value="'.$detail->emi_id.'"> </div> <div class="col-sm-4"> <h5>'.$detail->emi_lender.'</h5> </div> <div class="col-sm-3"> <p style="text-align: center;"><span> '.$detail->emi_period.' Month</span><br/>'.$detail->emi_interest.'% Int.</p> </div> <div class="col-sm-4"> <p style="text-align: right;"><span class="amount"> '.$detail->emi_period.'x 12,000</span><br/>INR/mo.</p> </div> </div>'; 
        } 
    }
                                    
    $content.='</div> <p class="has-error hide">Select any EMI Lender!</p> </div> <div class="mt-4"> <button type="button" class="btn " id="btn_emi_1" name="btn_emi_1">Continue</button> </div> </section> <section id="tb_std_emi" class="tab-panel"> <div class="emi-select-options pt-20"> <div>Select Your EMI Option</div> <div class="emi-options emi-options2 pt-10"> <div class="emi-option fill" data-emi-val="3" data-emi-opt="2">3M</div> <div class="emi-option" data-emi-val="6" data-emi-opt="2">6M</div> <div class="emi-option" data-emi-val="9" data-emi-opt="2">9M</div> <div class="emi-option" data-emi-val="12" data-emi-opt="2">12M</div> </div> <p class="has-error hide">Select any EMI Option!</p> </div> <div class="emi-select-lenders pt-20"> <div>Select Lender</div> <div class="emi-lenders-list emi-lenders-list2">';
    foreach($emi_details as $detail){
        if( $detail->emi_type_id == 2){
        $period = $detail->emi_period;
        $content.='<div class="emi-lender lender_'.$detail->emi_period.'"  data-period="'.$detail->emi_period.'" data-interest="'.$detail->emi_interest.'" data-type="'.$detail->emi_type_id.'"> <div class="col-sm-1"> <input type="radio" name="emi-lender" id="lender_'.$detail->emi_id.'" value="'.$detail->emi_id.'"> </div> <div class="col-sm-4"> <h5>'.$detail->emi_lender.'</h5> </div> <div class="col-sm-3"> <p style="text-align: center;"><span> '.$detail->emi_period.' Month</span><br/>'.$detail->emi_interest.'% Int.</p> </div> <div class="col-sm-4"> <p style="text-align: right;"><span class="amount"> '.$detail->emi_period.'x 12,000</span><br/>INR/mo.</p> </div> </div>'; } }
                                    
    $content.='</div> <p class="has-error hide">Select any EMI Lender!</p> </div> <div class="mt-4"> <button type="button" class="btn " id="btn_emi_11" name="btn_emi_11">Continue</button> </div> </section> <input type="hidden" name="emi-option" id="emi-option"> </div></div></div> <div id="emi_stage_2"> <div class="emi-user-details"> <div class="emi-sel-plan"> <div class="row"> <div class="col-sm-4"> <h5>PAY@EASE</h5> </div> <div class="col-sm-8"><div class="row"> <div class="col-sm-6"> <p style="text-align: center;"><span class="period">3</span> Month<br/><span class="interest">3</span>% Int.</p> </div> <div class="col-sm-6"> <p style="text-align: right;"><span class="period">3</span>x<span class="amt_emi">12,000</span><br/>INR/mo.</p> </div> <div class="col-sm-6"> <p style="text-align: center;">Total Payable</p> </div> <div class="col-sm-6"> <p style="text-align: right;"><span class="amt_total"> '.$total_amount.'</span><br/>INR/mo.</p> </div></div> </div> </div> </div> <h5 class="mt-5">Please share below details</h5> <div class="row"> <div class="col-lg-12 field"> <label>Full Name</label> <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Full Name"> <span class="has-error hide">Invalid Full Name!</span> </div> </div> <div class="row"> <div class="col-lg-12 field"> <label>Mobile Number</label> <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile Number"> <span class="has-error hide">Invalid Mobile Number!</span> </div> </div> <div class="row"> <div class="col-lg-12 field"> <label>Date of Birth</label> <input type="text" class="form-control" name="dob" id="dob" placeholder="Date Of Birth"> <span class="has-error hide">Invalid Date of Birth!</span> </div> </div> <div class="row"> <div class="col-lg-12 field"> <label>PAN Number</label> <input type="text" class="form-control" name="pan" id="pan" placeholder="XXXXXXXXXXX"> <span class="has-error hide">Invalid PAN!</span> </div> </div>'. wp_nonce_field( 'wps-frontend-post' ).'<input name="frm_emi" value="PayWithEMI" type="hidden"> <div class="mt-4"> <button type="button" class="btn " id="btn_emi_2" name="btn_emi_2">Continue</button> </div> </div> </div> </div> </form> </div> </div> </section> </div>'; 
    $content .= '</div></div><div id="otp_verify" class="container mt-5 '. $otp_show.'" > <form class="form" method="POST" id="frm_otp_verify" action=""> <div class="emi-verification col-lg-6" style="margin:auto;"> <h5 class="mt-3">OTP Verification</h5> <div class="row mb-3"> <div class="col-lg-12 field otp"> <label>Enter OTP</label> <input type="text" class="form-control" name="otp" id="otp" placeholder="XXXXXX"> <span class="has-error hide '.$error_msg.'">Invalid OTP!</span><p>Enter any 6 digit number</p> </div> </div>'. wp_nonce_field( 'wps-frontend-post' ).'<input name="frm_otp" value="OTP" type="hidden"> <input name="user_id" value="'.$user_id.'" type="hidden"> <input name="product_id" value="'.$product_id.'" type="hidden"> <input name="emi_id" value="'.$emi_id.'" type="hidden"> <input name="emi_type_id" value="'.$emi_type_id.'" type="hidden"> <input name="emi_amount" value="'.$emi_amount.'" type="hidden"> <input name="total_amount" value="'.$total_amount.'" type="hidden"> <input name="payment_type" value="'.$payment_type.'" type="hidden"> <div class="row" style="margin-top: 20px;"> <div class="col-lg-12"> <button type="button" class="btn " id="btn_otp_verify" name="btn_otp_verify"> Continue</button> </div> </div> </div> </form> </div>'; 
    $content .= '<div class="modal fade" id="emiPaymentAlertSuccess" tabindex="-1" role="dialog" aria-labelledby="paySuccessTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false"> <div class="modal-dialog modal-dialog-centered" role="document"> <div class="modal-content"> <div class="modal-body"> <button type="button" class="close hide" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> <h5 class="modal-title" id="exampleModalLongTitle" style="color: green;font-weight:bold;text-align:center">Payment Successful</h5> <div class="model-content"> <div style="font-size: 16px;color: #000">Electronics</div> <p style="opacity: .8">Laptop</p> <hr/> <div class="form-group row"> <label for="" class="col-sm-6">Product\'s Cost</label> <div class="col-sm-6"> <div style="text-align: right;color: #000">'.$purchase_amount.' INR</div> </div> </div> <div class="form-group row"> <label for="" class="col-sm-6">Interest Rate(12%)</label> <div class="col-sm-6"> <div style="text-align: right;color: #000">'.$interest.'</div> </div> </div> <hr/> <div class="form-group row"> <label for="" class="col-sm-6">Deductions</label> <div class="col-sm-6"> <div style="text-align: right;color: #000">'.$deduction.'</div> </div> </div> <hr/> <div class="form-group row total"> <label for="" class="col-sm-6">Total</label> <div class="col-sm-6"> <div style="text-align: right;">'.$total_amount.' INR</div> </div> </div> <hr/> <div class="form-group row reload hide"> <div class="col-sm-12"> <div style="text-align: center;">Redirecting...</div> </div> </div> </div> </div> </div> </div> </div>'; //$content.= $alert;
	return $content;
}
add_shortcode('payment_demo_process', 'payment_demo_shortcode');


function myscript() {
    if($_POST['frm_otp']) {
?>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#emiPaymentAlertSuccess').modal('show');
  });
</script>

<?php
} }
add_action( 'wp_footer', 'myscript' );