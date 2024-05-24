<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  private $msg;
  private $error;
  private $error_message;
  private $randval;
  public function __construct() {
        parent::__construct();
		
        if (!isset($this->session->optical_login))
         {
      redirect('login');
         }
        
        $this->load->model('Dashboard_model');
      
    }
  public function index()
  {
      $data['title']='Optical::Dashboard';
      $data['activecls']='Dashboard';
      $office_id=$this->session->office_id;
      $var_array=array($office_id);
      $data['getsalesamount']=$this->Dashboard_model->getsalesamount($var_array);
      $data['todayscollection']=$this->Dashboard_model->gettodaycollection($var_array);
      $data['todayscollection_COUNTER']=$this->Dashboard_model->getsalesamount_COUNTER($var_array);
      $data['gettotalitem']=$this->Dashboard_model->gettotalitem($var_array);
      $data['gettotalcustomer']=$this->Dashboard_model->gettotalcustomer($var_array);
      $data['pendingduebill']=$this->Dashboard_model->getpendingduebill($var_array);
      $data['getpuramt']=$this->Dashboard_model->getpuramt($var_array);
      $data['getdueamt']=$this->Dashboard_model->getalldueamount($var_array);
      $week_start = date('Y-m-d', strtotime('-15 days'));
         $week_end = date('Y-m-d');
         $chart_dates=$patient_count=$visit_count=[];
         while($week_start<=$week_end)
         {
             $chart_dates[]=date('d/m/y', strtotime($week_start));
             $patient_count[]=$this->db->select('ifnull(sum(netamount),0) as amt')->get_where('sales_master',["sales_date"=>$week_start])->row()->amt;;

             
             $week_start = date('Y-m-d', strtotime("+1 day", strtotime($week_start)));
         }
         $data['chart_dates']=$chart_dates;
          $data['patient_count']=$patient_count;
      $content=$this->load->view('master/dashboard',$data,true);
      $this->load->view('includes/layout',['content'=>$content]);
  }
  public function EMR_Dashboard()
  {
    $this->db = $this->load->database('emrdb', TRUE);
    $cdate=date('Y-m-d');$cind_doc='';
    $today_patient= $this->db->query('SELECT count(*) as tcount FROM patient_appointment where appointment_date="'.$cdate.'" '.$cind_doc.' ')->row()->tcount;
    $today_collection = $this->db->query('SELECT sum(grand_total) as net_amount FROM billing_master where  billing_date="'.$cdate.'" ')->row()->net_amount;
    $advancepatientcashamount=$this->db->query("select sum(opdcharge.amount) as total from patient_appointment  left join opdcharge on patient_appointment.appointment_opd_charge_id=opdcharge.opdcharge_id
        where appointment_date = '$cdate'  ")->row()->total;
     $pettycashcr=$this->db->query("select sum(petty_amount) as pettycashcr from petty_cash  where petty_date = '$cdate' and pay_type=1")->row()->pettycashcr;
       $pettycashdr=$this->db->query("select sum(petty_amount) as pettycashdr from petty_cash  where petty_date = '$cdate' and pay_type=2")->row()->pettycashdr;
       $today_collections=$today_collection+$advancepatientcashamount+$pettycashcr-$pettycashdr;
       $today_collection=number_format($today_collections, 2);
       $total_doctors = $this->db->query('SELECT count(*) as tcount FROM doctors_registration ')->row()->tcount;
       $total_patient = $this->db->query('SELECT count(*) as tcount FROM patient_registration ')->row()->tcount;
       $todaynew_patient = $this->db->query('SELECT count(*) as newcount FROM patient_registration where entry_date="'.$cdate.'" ')->row()->newcount;
       $todaynewfol_patient = $this->db->query('SELECT count(*) as folcount FROM patient_appointment where appointment_date="'.$cdate.'"  '.$cind_doc.'  and  patient_registration_id NOT IN (select patient_registration_id from patient_registration  where entry_date="'.$cdate.'") ')->row()->folcount;
      $doctor_id_new_cond='';
      $opto_waiting_cnt_status_opto=0;$Opto_inprogressd=0;
      $Opto_waiting =$this->Dashboard_model->Get_Waiting_opto($doctor_id_new_cond);
      $Opto_inprogress =$this->Dashboard_model->Patient_status(1,0,$doctor_id_new_cond);
      $Opto_completed =$this->Dashboard_model->Patient_status(1,1,$doctor_id_new_cond);
      $Doc_inprocess =$this->Dashboard_model->Patient_status(3,0,$doctor_id_new_cond);
      $Doc_comp =$this->Dashboard_model->Patient_status(3,1,$doctor_id_new_cond);
      $crossdocst_cnt =$this->Dashboard_model->crossdocst_cnt_model($cdate);
      if($Opto_waiting[0]['cnt_status_opto'])
      {
        $opto_waiting_cnt_status_opto=$Opto_waiting[0]['cnt_status_opto'];
      }
      if($Opto_inprogress)
      {
        if($Opto_inprogress[0]['cnt_patient_status']>0)
        {
          $Opto_inprogressd=$Opto_inprogress[0]['cnt_patient_status'];
        }
      }
      $htdoc='';
      $getv1=$opto_waiting_cnt_status_opto + $Opto_inprogressd;
      $doctorapp =$this->Dashboard_model->Doctor_App_Status($doctor_id_new_cond);
      if($doctorapp){
      $sl=1;
      $dater=date('Y-m-d');
      foreach($doctorapp as $doname)
      {
        $docid=$doname['doctors_registration_id'];
        $sqll2 = "select count(*) as cnt from patient_appointment  where 
        doctor_id=$docid and appointment_date='$dater'";
             $result_row1=$this->db->query($sqll2); 
             $res1= $result_row1->result_array();
             $cnt=$res1[0]['cnt'];

              $Opto_waiting=$Opto_comp=$dooc_inc=$dooc_com=$Opto_inp=$dooc_incg=0;

                  $dte=date('Y-m-d');

                  $sql1 = "SELECT count(*) as cnt_status_opto FROM patient_registration inner join  patient_appointment on  patient_registration.patient_registration_id=patient_appointment.patient_registration_id  left join complaints on patient_appointment.complaints_id=complaints.complaints_id where   appointment_date='$dte' and doctor_id=$docid    and cancel_flag=0 and patient_appointment_id not in (select patient_appointment_id from examination) order by patient_appointment_id DESC";
                  $result_row1=$this->db->query($sql1); 
                  $res1= $result_row1->result_array ();
                  if($res1)
                  {
                      $Opto_waiting=$res1[0]['cnt_status_opto'];
                  }
                  //opto inpro
                   $whr='';
                $userstatus=1;$staus=0;
                if($userstatus==1)
                {
                  $whr=" and optho_action=$staus and doc_action!=1";
                }
                if($userstatus==2)
                {
                  $whr=" and optho_action=1 and  confirm_flag=0 and doc_action=$staus";
                }
                if($userstatus==3)
                {
                  $whr=" and optho_action=1 and  confirm_flag=1 and doc_action=$staus";
                }
                $dte=date('Y-m-d');
               $sql2 = "select count(*) as cnt_patient_status from examination where examination_date='$dte' and doctor_id=$docid  $whr";
                $result_row2=$this->db->query($sql2); 
                $res2= $result_row2->result_array ();
                if($res2)
                {
                  $Opto_inp=$res2[0]['cnt_patient_status'];
                }
                //end opto inpo

                  ///opto com
                  $whr='';
                  $userstatus=1;$staus=1;
                if($userstatus==1)
                {
                  $whr=" and optho_action=$staus and doc_action!=1 and  confirm_flag=0";
                }
                if($userstatus==2)
                {
                  $whr=" and optho_action=1 and  confirm_flag=0 and doc_action=$staus";
                }
                if($userstatus==3)
                {
                  $whr=" and optho_action=1 and  confirm_flag=1 and doc_action=$staus";
                }
                $dte=date('Y-m-d');
               $sql2 = "select count(*) as cnt_patient_status from examination where examination_date='$dte' and doctor_id=$docid  $whr";
                $result_row2=$this->db->query($sql2); 
                $res2= $result_row2->result_array ();
                if($res2)
                {
                  $Opto_comp=$res2[0]['cnt_patient_status'];
                }
                //end opto comp

                 ///Doc Inpro
                  $whr='';
                  $userstatus=3;$staus=0;
                if($userstatus==1)
                {
                  $whr=" and optho_action=$staus and doc_action!=1";
                }
                if($userstatus==2)
                {
                  $whr=" and optho_action=1 and  confirm_flag=0 and doc_action=$staus";
                }
                if($userstatus==3)
                {
                  $whr=" and optho_action=1 and  confirm_flag=1 and doc_action=$staus";
                }
                $dte=date('Y-m-d');
               $sql3 = "select count(*) as cnt_patient_status from examination where examination_date='$dte' and doctor_id=$docid  $whr";
                $result_row3=$this->db->query($sql3); 
                $res3= $result_row3->result_array ();
                if($res3)
                {
                  $dooc_inc=$res3[0]['cnt_patient_status'];
                }
                //end Doc Inpro

                   ///Doc Comp
                  $whr='';
                  $userstatus=3;$staus=1;
                if($userstatus==1)
                {
                  $whr=" and optho_action=$staus and doc_action!=1";
                }
                if($userstatus==2)
                {
                  $whr=" and optho_action=1 and  confirm_flag=0 and doc_action=$staus";
                }
                if($userstatus==3)
                {
                  $whr=" and optho_action=1 and  confirm_flag=1 and doc_action=$staus";
                }
                $dte=date('Y-m-d');
               $sql4 = "select count(*) as cnt_patient_status from examination where examination_date='$dte' and doctor_id=$docid  $whr";
                $result_row4=$this->db->query($sql4); 
                $res4= $result_row4->result_array ();
                if($res4)
                {
                  $dooc_com=$res4[0]['cnt_patient_status'];
                }
                //end Doc Comp
                //doc inp
                  $whr='';
                  $userstatus=3;$staus=0;
                if($userstatus==1)
                {
                  $whr=" and optho_action=$staus and doc_action!=1";
                }
                if($userstatus==2)
                {
                  $whr=" and optho_action=1 and  confirm_flag=0 and doc_action=$staus";
                }
                if($userstatus==3)
                {
                  $whr=" and optho_action=1 and  confirm_flag=1 and doc_action=$staus";
                }
                $dte=date('Y-m-d');
               $sql4 = "select count(*) as cnt_patient_status from examination where examination_date='$dte' and doctor_id=$docid  $whr";
                $result_row4=$this->db->query($sql4); 
                $res4= $result_row4->result_array ();
                if($res4)
                {
                  $dooc_incg=$res4[0]['cnt_patient_status'];
                }
                //end doc
                   $opp=$Opto_waiting+$Opto_inp;
                  $ff= $dooc_inc;
                  
                $doctdetail="All Patients-$opp,Optometry completed-$Opto_comp ,Examination Inprogress-$ff,Examination Completed-$dooc_com";
                $ddn=$doname['name'];
                $htdoc.='<tr>
                        <td>'.$sl.'</td>
                        <td><a style="text-decoration: underline;color: blue;" data-toggle="tooltip" title="'.$doctdetail.'">'.$ddn.'</a></td>
                        <td>'.$cnt.'</td>
                        <td><span onclick="pat_view('.$docid.')" class="btn btn-success" style="cursor:pointer;"><i class="la la-eye"></i></span></td>
                      </tr>';
                      $sl++;
              }
            }

      $htmldata='<div id="emr_dashboard_pop" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="front_emr_screen">

                           <div class="row">  <!-- 1st row-->
                                 <div class="col-xl-3 col-lg-6 col-12"> <!-- 1st box-->
                                      <div class="card bg-gradient-directional-danger">
                                        <div class="card-content">
                                          <div class="card-body">
                                            <div class="media d-flex">
                                              <div class="media-body text-white text-left">
                                                <h3 class="text-white">'.$today_patient.'</h3>
                                                <span>Todays Patients</span>
                                              </div>
                                              <div class="align-self-center">
                                                <i class="icon-users text-white font-large-2 float-right"></i>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      </div>  <!-- end 1st box-->

                                      <div class="col-xl-3 col-lg-6 col-12"> <!--  2nd box-->
                                        <div class="card bg-gradient-directional-success">
                                          <div class="card-content">
                                            <div class="card-body">
                                              <div class="media d-flex">
                                                <div class="media-body text-white text-left">
                                                  <h3 class="text-white">'.$today_collection.'</h3>
                                                  <span>Todays Collection</span>
                                                </div>
                                                <div class="align-self-center">
                                                  <i class="la la-credit-card text-white font-large-2 float-right"></i>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        </div>  <!-- end 2nd box-->

                                        <div class="col-xl-3 col-lg-6 col-12"> <!--  3rd box-->
                                          <div class="card bg-gradient-directional-amber">
                                            <div class="card-content">
                                              <div class="card-body">
                                                <div class="media d-flex">
                                                  <div class="media-body text-white text-left">
                                                    <h3 class="text-white">'.$total_doctors.'</h3>
                                                    <span>Total  Doctors</span>
                                                  </div>
                                                  <div class="align-self-center">
                                                    <i class="la la-stethoscope text-white font-large-2 float-right"></i>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          </div>   <!-- end 3rd box-->

                                          <div class="col-xl-3 col-lg-6 col-12"> <!--  4th box-->
                                              <div class="card bg-gradient-directional-info">
                                                <div class="card-content">
                                                  <div class="card-body">
                                                    <div class="media d-flex">
                                                      <div class="media-body text-white text-left">
                                                        <h3 class="text-white">'.$total_patient.'</h3>
                                                        <span>Total Patients</span>
                                                      </div>
                                                      <div class="align-self-center">
                                                        <i class="icon-users text-white font-large-2 float-right"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              </div> <!-- end 4th box-->

                           </div>       <!-- end 1st row-->

                           <div class="row"> <!--  2nd row-->
                                  <div class="col-xl-3 col-lg-6 col-12"> <!-- 5th box-->
                                    <div class="card bg-gradient-x-pink">
                                      <div class="card-content">
                                        <div class="card-body">
                                          <div class="media d-flex">
                                            <div class="media-body text-white text-left">
                                              <h3 class="text-white">'.$todaynew_patient.'</h3>
                                              <span>New Patients</span>
                                            </div>
                                            <div class="align-self-center">
                                              <i class="icon-users text-white font-large-2 float-right"></i>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    </div>  <!-- end 5th box-->
 
                                    <div class="col-xl-3 col-lg-6 col-12">  <!-- 6th box-->
                                      <div class="card bg-gradient-x-purple">
                                        <div class="card-content">
                                          <div class="card-body">
                                            <div class="media d-flex">
                                              <div class="media-body text-white text-left">
                                                <h3 class="text-white">'.$todaynewfol_patient.'</h3>
                                                <span>Followup Patients</span>
                                              </div>
                                              <div class="align-self-center">
                                                <i class="icon-users text-white font-large-2 float-right"></i>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      </div>  <!-- end 6th box-->


                                      <div class="col-xl-3 col-lg-6 col-12"> <!-- 7th box-->
                                        <div class="card bg-gradient-directional-cyan">
                                          <div class="card-content">
                                            <div class="card-body">
                                              <div class="media d-flex">
                                                <div class="media-body text-white text-left">
                                                  <h3 class="text-white">'.$getv1.'</h3>
                                                  <span>All Patients</span>
                                                </div>
                                                <div class="align-self-center">
                                                  <i class="icon-users text-white font-large-2 float-right"></i>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        </div> <!-- end 7th box-->


                                          <div class="col-xl-3 col-lg-6 col-12">  <!-- 8th box-->
                                            <div class="card bg-gradient-y2-pink">
                                              <div class="card-content">
                                                <div class="card-body">
                                                  <div class="media d-flex">
                                                    <div class="media-body text-white text-left">
                                                      <h3 class="text-white">'.$Opto_completed[0]['cnt_patient_status'].'</h3>
                                                      <span>Optometry completed</span>
                                                    </div>
                                                    <div class="align-self-center">
                                                      <i class="icon-users text-white font-large-2 float-right"></i>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            </div> <!-- end 8th box-->

                           </div>  <!--  2nd end row-->

                             <div class="row" >  <!--  3rd  row-->
                                    <div class="col-12 col-md-6">  <!--   col-12 col-md-6 1st -->
                                          <div class="card">
                                                 <div class="card-header">
                                                    <h4 class="card-title"><b>Todays Doctors Appointments</b></h4>
                                                </div>
                                                <div class="card-content">
                                                   <div class="card-body">
                                                        <table class="table table-bordered table-hover" id="emr_tab_das">
                                                         <thead>
                                                          <tr>
                                                              <th>Sl No</th>
                                                              <th>Doctor Name</th>
                                                              <th>Total Appointment</th>
                                                              <th>View</th>
                                                          </tr>
                                                      </thead>
                                                      '.$htdoc.'
                                                          <tbody></tbody></table>
                                                   </div> <!--  end  card-body -->
                                                </div> <!--  end  card-content -->
                                          </div>

                                             



                                     </div> <!--  end  col-12 col-md-6 1st -->

                                     <div class="col-md-6">
                                                 <div class="row">
                                                         <div class="col-xl-6 col-lg-6 col-md-6 col-12"> <!--  9th box -->
                                                            <div class="card bg-gradient-directional-teal">
                                                              <div class="card-content">
                                                                <div class="card-body">
                                                                  <div class="media d-flex">
                                                                    <div class="media-body text-white text-left">
                                                                      <h3 class="text-white">'.$Doc_inprocess[0]['cnt_patient_status'].'</h3>
                                                                      <span>Examination Inprogress</span>
                                                                    </div>
                                                                    <div class="align-self-center">
                                                                      <i class="icon-users text-white font-large-2 float-right"></i>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                       
                                                        </div>   <!--  end 9th box -->

                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12"> <!--   10th box -->
                                                            <div class="card bg-gradient-y-red">
                                                              <div class="card-content">
                                                                <div class="card-body">
                                                                  <div class="media d-flex">
                                                                    <div class="media-body text-white text-left">
                                                                      <h3 class="text-white">'.$Doc_comp[0]['cnt_patient_status'].'</h3>
                                                                      <span>Examination Completed </span>
                                                                    </div>
                                                                    <div class="align-self-center">
                                                                      <i class="icon-users text-white font-large-2 float-right"></i>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>  <!--  end 10th box -->

                                                  </div> <!--  end  row -->

                                                   <div class="row">
                                                          <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                              <div class="form-group form-group-compose">
                                                                  <!-- compose button  -->
                                                                  <button onclick="showallpatient_details()" type="button" class="btn btn-danger btn-glow btn-block my-2 compose-btn">
                                                                      <i class="ft-info"></i>
                                                                      Appointment Status
                                                                  </button>

                                                                 
                      
                                                              </div>
                                                           
                                                            </div> 

                                                             <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                              <div class="form-group form-group-compose">

                                            <button style="margin-top: 5%;" onclick="getallcrossdoctorstatus()" type="button" class="btn btn-primary btn btn-block compose-btn">
                <i class="ft-info"></i>
                Cross Doctor Status  <span id="st_cnt4" style="font-size: 16px;background: #fff;color:black;" class="badge badge-pill badge badge-danger ml-1">'.$crossdocst_cnt[0]['cnt'].'</span>
            </button>

            </div>


                                                   </div>
                                              </div> <!--   end col-md-6-->
                        
                             </div> <!--   end 3rd row-->


                             
                            
                        </div>

                    </div>
                     <div class="col-lg-12 col-md-12" id="doc_emr_screen" style="display:none;">

                              </div>
                               <div class="col-lg-12 col-md-12" id="app_emr_screen" style="display:none;">
                                  '.$this->app_v_emr().'
                              </div>
                              <div class="col-lg-12 col-md-12" id="cross_emr_screen" style="display:none;">
                                  '.$this->cross_v_emr().'
                              </div>
                </div>
                <div class="modal-footer">
                
                    <button type="button" id="mclose" class="btn btn-danger btn-sm cls upclick" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>';
      echo json_encode(array('msg' =>'success','htmldata'=>$htmldata,'error'=>'','error_message' =>''));
  }
  public function cross_v_emr()
  {
     $docco='';
    $doctors =$this->Dashboard_model->Doctor_App_Status($doctor_id_new_cond='');
    if($doctors){ foreach ($doctors as $datadoc) 
       {
        $docregid=$datadoc['doctors_registration_id'];
        $docname=$datadoc['name'];
          $docco.='<option value="'.$docregid.'">'.$docname.'</option>';
      }
    }
    $html='<div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-3">
              <select class="form-control select2" name="cross_all_cons" id="cross_all_cons">
                 <option value="0">All Consulatant</option>
                  '.$docco.'
              </select>
            </div>
            <div class="col-md-3">
              <input type="date" style="height:40px;" class="form-control date_pic_class" name="cross_date_pic" id="cross_date_pic" >
            </div>
            <button type="button" onclick="getallcrossdoctorstatus()" class="btn btn-danger"><i class="ft-search"></i></button>
            <h3 style="    padding-left: 2%;
    color: red;
    font-weight: bold;
    font-family: sans-serif;">Total Count : <t id="cross_cnt_contr">0</t></h3>
        </div>
        <br/>
      
        <div class="row">
            <div class="col-md-12" id="cross_ref_data">
              
            </div>
        </div>
   
 ';
 return $html;
  }
  public function Get_cross_data()
{
    $doc_id=$this->input->post('doc_id');
    $cross_date_pic=$this->input->post('cross_date_pic');
    if($cross_date_pic)
    {
        $get_result=$this->Dashboard_model->Getcross_rreddata($cross_date_pic,$doc_id);
        //print_r($get_result);exit;
        if($get_result)
        {
            $html='<div class="table-responsive"><table class="table table-bordered table-hover" id="data_cross"><thead></tr><th>SL No</th><th>Optometrist Date</th><th>Cross Date</th><th>Patient Name</th><th>MRD NO</th><th>Age/YY MM</th><th>Mobile No</th><th>Doctor Name</th><th>Cross Doctor Name</th><th>Description</th></tr></thead><tbody>';
          $sl=1;
            foreach ($get_result as $data) 
            {
                $docname=$this->db->select('name')
                ->from('doctors_registration')
                ->where(array('doctors_registration_id'=>$data['cross_doctor_id']))
                ->get()->row()->name;

                if($data['gender']==1)
                  {
                     $gen='Male';
                  }
                  elseif($data['gender']==2)
                  {
                     $gen='Female';
                  }
                  else
                  {
                     $gen='Transgender';
                  }
                  $dia='';
                  if($data['dialysis_con']==2)
                  {
                    $dia='<span class="badge badge-success">Dilation</span>';
                  }
                  $fl=2;
                  $socurce=$sc='';
                $var_array=array($data['patient_registration_id'],$this->session->userdata('office_id'));
                $getmaster_so=$this->Dashboard_model->Get_Pat_Source($var_array);
                if($getmaster_so)
                {
                    $socurce=$getmaster_so[0]['source'];
                    $sc="<y style='color:green;font-weight:bold'>Source:$socurce</y>";
                }
                  $chkvalfd=$data['pateint_name'];
                  $nwpri='<td><button type="button" class="btn btn-success" onclick="examinationnewprint('.$data['examination_id'].')"><i class="la la-print"></i></button></td>';
                $html.='<tr><td>'.$sl.'</td><td>'.$data['opthdate'].'</td><td>'.$data['cross_date'].'</td><td>'.$chkvalfd.'  '.$dia.' '.$sc.'</td><td>'.$data['mrdno'].'</td><td>'.$gen.''.$data['ageyy'].''.$data['agemm'].'</td><td>'.$data['mobileno'].'</td><td>'.$data['doctorname'].'</td><td>'.$docname.'</td><td>'.$data['cross_description'].'</td></tr>';
            $sl++;
            
            }
            $ssl=$sl-1;
            $crosscnt=$ssl;
            $html.='</tbody></table></div>';
            echo json_encode(array('msg' =>$html,'crosscnt'=>$crosscnt,'error'=>'','error_message' =>''));
        }
        else {
            echo json_encode(array('msg' =>'','error'=>'No data found','error_message' =>''));
        }
    }
}
  public function app_v_emr()
  {
    $docco='';
    $doctors =$this->Dashboard_model->Doctor_App_Status($doctor_id_new_cond='');
    if($doctors){ foreach ($doctors as $datadoc) 
       {
        $docregid=$datadoc['doctors_registration_id'];
        $docname=$datadoc['name'];
          $docco.='<option value="'.$docregid.'">'.$docname.'</option>';
      }
    }
    $html='<div class="row">
            <div class="col-md-3"><button style="margin-bottom: 2%;" onclick="emrback()" type="button" class="btn  btn-info" ><i class="la la-backward"></i>Back</button><br/></div>
            <div class="col-md-3">
              <select class="form-control select2" name="all_cons" id="all_cons">
                 <option value="0">All Consulatant</option>
                  '.$docco.'
              </select>
            </div>
            <div class="col-md-3">
              <input type="date" style="height:40px;" class="form-control date_pic_class" name="date_pic" id="date_pic" >
            </div>
            <button type="button" onclick="showallpatient_details(0)" class="btn btn-danger"><i class="ft-search"></i></button>
        </div>
        <br/>
<ul class="nav nav-pills nav-pill-bordered">
    <li class="nav-item">
        <a class="nav-link active" id="homeOpt1-tab" data-toggle="pill" href="#homeOpt1" aria-expanded="true">All Patients <span id="st_cnt1" style="font-size: 16px;background: #d32f2f;" class="badge badge-pill badge-glow badge-danger ml-1"></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="homeOpt2-tab" data-toggle="pill" href="#homeOpt2" aria-expanded="false">Optometry Completed <span id="st_cnt2" style="font-size: 16px;background: #d32f2f;" class="badge badge-pill badge-glow badge-danger ml-1"></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="homeOpt3-tab" data-toggle="pill" href="#homeOpt3" aria-expanded="false">Examination Inprogress <span id="st_cnt3"  style="font-size: 16px;background: #d32f2f;" class="badge badge-pill badge-glow badge-danger ml-1"></span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="homeOpt4-tab" data-toggle="pill" href="#homeOpt4" aria-expanded="false">Examination Completed <span id="st_cnt41" style="font-size: 16px;background: #d32f2f;" class="badge badge-pill badge-glow badge-danger ml-1"></span></a>
    </li>
   
   
</ul>
<div class="tab-content px-1 pt-1" id="atsa">';
  
    $x = 1;
    while($x <= 4) {
        $cls='';
        if($x==1)
        {
            $cls='flipInY active';
        }
     
     $html.='<div role="tabpanel" class="tab-pane animated '.$cls.'" id="homeOpt'.$x.'" aria-labelledby="homeOpt'.$x.'-tab" aria-expanded="true">
   
        <br/>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="pat_st_av'.$x.'" style="width:100%;font-size: 12px;">
                   <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Patient Name</th>
                            <th>MRD NO</th>
                            <th>DOB & Age</th>
                            <th>App.Time</th>
                            <th>Particulars</th>
                            <th>Consultant</th>
                            <th>W.T</th>
                            <th>Status</th>
                        </tr>
                   </thead>
                   <tbody id="show_all_pat_st_av'.$x.'" >
                     
                   </tbody>
               </table>
            </div>
        </div>
    </div>';
     
    $x++;
    }
   
  
   
   $html.='<style type="text/css">
       #pat_st_av1,#pat_st_av2,#pat_st_av3,#pat_st_av4.dataTable >tbody th, #pat_st_av1,#pat_st_av2,#pat_st_av3,#pat_st_av4.dataTable tbody td {
    padding: 0px 0px;
}

#pat_st_av1,#pat_st_av2,#pat_st_av3,#pat_st_av4.dataTable thead th, #pat_st_av1,#pat_st_av2,#pat_st_av3,#pat_st_av4.dataTable thead td {
    padding: 2px 5px;
   
}

   </style>
</div>';
return $html;
  }

  public function pat_view()
  {
     $this->db = $this->load->database('emrdb', TRUE);
    $doctor_id=$this->input->post('docid');
    if($doctor_id>0)
    {
       $pat_Det_Doc =$this->Dashboard_model->pat_Det_Doc($doctor_id);
      // print_R($pat_Det_Doc);exit;
       if($pat_Det_Doc)
       {
        $html='<button style="margin-bottom: 2%;" onclick="emrback()" type="button" class="btn  btn-info" ><i class="la la-backward"></i>Back</button><br/><table id="pp_pat" class="table table-bordered table-hover"><thead><tr><th>SL NO</th><th>Patient Name</th><th>Appointment Time</th><th>Status</th></tr></thead><tbody>';
        $sl=1;
        $stat='';
          foreach ($pat_Det_Doc as $datadoc) 
          {
              $pateint_name=$datadoc['pateint_name'];
              $patient_registration_id=$datadoc['patient_registration_id'];
              $patient_appointment_id=$datadoc['patient_appointment_id'];
              $mrdno=$datadoc['mrdno'];
              $appointment_time=$datadoc['appointment_time'];
$stat='Nill';
              $sqll1 = "select confirm_flag,optho_action,doc_action from examination where patient_appointment_id=$patient_appointment_id and patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll1); 
                    $res1= $result_row1->result_array ();
                    if($res1)
                    {
                      $confirm_flag=$res1[0]['confirm_flag'];
                      
                      $doc_action=$res1[0]['doc_action'];
                      if($confirm_flag==0)
                      {
                        $optho_action=$res1[0]['optho_action'];
                        if($optho_action==0)
                        {
                          $stat='<p style="color:red;">Optometry inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:green;">Optometrists Completed</p>';
                        }
                      }

                      if($confirm_flag==1)
                      {
                        $doc_action=$res1[0]['doc_action'];
                        if($doc_action==0)
                        {
                          $stat='<p style="color:red;">Consultant Inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:green;">Consultant Completed</p>';
                        }
                      }
                    }

                    $html.='<tr>
                        <td>'.$sl.'</td> 
                        <td>'.$pateint_name.'</td> 
                        <td>'.$appointment_time.'</td> 
                        <td>'.$stat.'</td> 
                    </tr>';
                    $sl++;

          }
          $html.='</tbody></table>';
          echo json_encode(array('msg' =>$html,'error'=>'','error_message' =>''));
       }
       else {
          echo json_encode(array('msg' =>'','error'=> 'No Appointment','error_message' =>''));
       }
    }
  }
   public function patview_status()
  {
    $this->db = $this->load->database('emrdb', TRUE);
    $sl1=0;
    $sl2=0;
    $sl3=0;
    $sl4=0;
    $html1='';$html2='';$html3='';$html4='';
    $docid=$this->input->post('doc_id');
    $curdate=$this->input->post('curdate');
    $type=$this->input->post('type');
    if($type==0)
    {
        $Response1 =$this->Dashboard_model->Patient_Status_Dash($docid,$curdate,1);
        if($Response1)
        {
            $sl1=1;
            
            $waiting_time=0;
            foreach($Response1 as $data)
            {
              $rooming=$data['rooming'];
              $checkTime = strtotime($data['appointment_time']);
              $mrdno = strtotime($data['mrdno']);
              $patient_appointment_id=$data['patient_appointment_id'];
              $checkTime =date('H:i:s', $checkTime);
              $loginTime = strtotime($data['appointment_time']);
              $time1 = new DateTime($data['appointment_time']);
              $time2 = new DateTime(date('H:i:s'));
              $interval = $time1->diff($time2);
              $diff= $interval->format('%s second(s)');
              $patient_registration_id=$data['patient_registration_id'];
              $opd=$data['appointment_opd_charge_id'];
              $opdcharge=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->name;
              $amount=$grand_total=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->amount;
              $opdchargeamt=$opdcharge.'-'.$amount.',';
              $clrrow='';
              if($data['cancel_flag']==1)
              {
                $clrrow=' style="background:yellow"';
              }

                 $sqll2 = "select count(*) as cnt from patient_appointment  where 
               patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll2); 
                    $res1= $result_row1->result_array();
                    $cnt=$res1[0]['cnt'];
                    $new='';
                    if($cnt==1)
                    {
                      $new='<span class="badge badge-danger">New</span>';
                      $newclr="style='font-weight:bold;color:red;'";
                    }
                    else
                    {
                       $newclr="style='font-weight:bold;color:blue;'";
                    }

                    $sqll = "select doctors_registration.name as doctorname from patient_appointment inner join doctors_registration on patient_appointment.doctor_id=doctors_registration.doctors_registration_id where 
               patient_registration_id=$patient_registration_id  order by patient_appointment.patient_appointment_id DESC";
                    $result_row=$this->db->query($sqll); 
                    $res= $result_row->result_array ();
                    if($res)
                    {
                      $doc=$res[0]['doctorname'];
                    }
                    else
                    {
                      $doc='';
                    }
                    $stat='<p style="color:#fff;">Nill</p>';
                    $sqll1 = "select confirm_flag,optho_action,doc_action from examination where patient_appointment_id=$patient_appointment_id and patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll1); 
                    $res1= $result_row1->result_array ();
                    if($res1)
                    {
                      $confirm_flag=$res1[0]['confirm_flag'];
                      $doc_action=$res1[0]['doc_action'];
                      if($confirm_flag==0)
                      {
                        $optho_action=$res1[0]['optho_action'];
                        if($optho_action==0)
                        {
                          $stat='<p style="color:#fff;">Optometry inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Optometrists Completed</p>';
                        }
                      }

                      if($confirm_flag==1)
                      {
                        $doc_action=$res1[0]['doc_action'];
                        if($doc_action==0)
                        {
                          $stat='<p style="color:#fff;">Consultant Inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Consultant Completed</p>';
                        }
                      }
                    }
                    $classn='bgsts';
                    if($rooming==1)
                    {
                      $classn='';
                      $stat='<a class="buttonbl" href="#">IN</a>';
                    }

                    $nedcodcomtime=date('Y-m-d H:i:s');
                    $getresult_doctcom=$this->Dashboard_model->getlastcompdatetime($patient_registration_id,$patient_appointment_id);
                    if($getresult_doctcom)
                    {
                        if($getresult_doctcom[0]['doctor_completed_datetime'])
                        {
                          $nedcodcomtime=$getresult_doctcom[0]['doctor_completed_datetime'];
                        }
                    }
               
                        $billing_time=$data['adate'].' '.$checkTime;
                        $waiting_time= $this->find_date_diff($billing_time,$nedcodcomtime) ;

                       

                        $html1.='<tr>
                                <td>'.$sl1.'</td>
                                <td><c>'.$data['pateint_name'].' '.$new.'</c></td>
                                <td>'.$data['mrdno'].'</td>
                                <td>'.$data['dateofbirth'].' & '.$data['ageyy'].'</td>
                                <td>'.$data['appointment_time'].'</td>
                                <td>'.$opdchargeamt.'</td>
                                <td>'.$doc.'</td>
                                <td>'.$waiting_time.'</td>
                                <td class="'.$classn.'">'.$stat.'</td>
                              </tr>';
                          $sl1++;
                         
            }
            if($sl1>0)
            {
              $sl1=$sl1-1;
            }

            
        }
        $Response2 =$this->Dashboard_model->Patient_Status_Dash($docid,$curdate,2);
        if($Response2)
        {
            $sl2=1;
            
            $waiting_time=0;
            foreach($Response2 as $data)
            {
              $checkTime = strtotime($data['appointment_time']);
              $mrdno = strtotime($data['mrdno']);
              $patient_appointment_id=$data['patient_appointment_id'];
              $checkTime =date('H:i:s', $checkTime);
              $loginTime = strtotime($data['appointment_time']);
              $time1 = new DateTime($data['appointment_time']);
              $time2 = new DateTime(date('H:i:s'));
              $interval = $time1->diff($time2);
              $diff= $interval->format('%s second(s)');
              $patient_registration_id=$data['patient_registration_id'];
              $opd=$data['appointment_opd_charge_id'];
              $opdcharge=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->name;
              $amount=$grand_total=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->amount;
              $opdchargeamt=$opdcharge.'-'.$amount.',';
              $clrrow='';
              if($data['cancel_flag']==1)
              {
                $clrrow=' style="background:yellow"';
              }

                 $sqll2 = "select count(*) as cnt from patient_appointment  where 
               patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll2); 
                    $res1= $result_row1->result_array();
                    $cnt=$res1[0]['cnt'];
                    $new='';
                    if($cnt==1)
                    {
                      $new='<span class="badge badge-danger">New</span>';
                      $newclr="style='font-weight:bold;color:red;'";
                    }
                    else
                    {
                       $newclr="style='font-weight:bold;color:blue;'";
                    }

                    $sqll = "select doctors_registration.name as doctorname from patient_appointment inner join doctors_registration on patient_appointment.doctor_id=doctors_registration.doctors_registration_id where 
               patient_registration_id=$patient_registration_id  order by patient_appointment.patient_appointment_id DESC";
                    $result_row=$this->db->query($sqll); 
                    $res= $result_row->result_array ();
                    if($res)
                    {
                      $doc=$res[0]['doctorname'];
                    }
                    else
                    {
                      $doc='';
                    }
                    $stat='<p style="color:#fff;">Nill</p>';
                    $sqll1 = "select confirm_flag,optho_action,doc_action from examination where patient_appointment_id=$patient_appointment_id and patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll1); 
                    $res1= $result_row1->result_array ();
                    if($res1)
                    {
                      $confirm_flag=$res1[0]['confirm_flag'];
                      $doc_action=$res1[0]['doc_action'];
                      if($confirm_flag==0)
                      {
                        $optho_action=$res1[0]['optho_action'];
                        if($optho_action==0)
                        {
                          $stat='<p style="color:#fff;">Optometry inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Optometrists Completed</p>';
                        }
                      }

                      if($confirm_flag==1)
                      {
                        $doc_action=$res1[0]['doc_action'];
                        if($doc_action==0)
                        {
                          $stat='<p style="color:#fff;">Consultant Inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Consultant Completed</p>';
                        }
                      }
                    }

                    $nedcodcomtime=date('Y-m-d H:i:s');
                    $getresult_doctcom=$this->Dashboard_model->getlastcompdatetime($patient_registration_id,$patient_appointment_id);
                    if($getresult_doctcom)
                    {
                        if($getresult_doctcom[0]['doctor_completed_datetime'])
                        {
                          $nedcodcomtime=$getresult_doctcom[0]['doctor_completed_datetime'];
                        }
                    }
               
                        $billing_time=$data['adate'].' '.$checkTime;
                        $waiting_time= $this->find_date_diff($billing_time,$nedcodcomtime) ;

                       

                        $html2.='<tr>
                                <td>'.$sl2.'</td>
                                <td><c>'.$data['pateint_name'].' '.$new.'</c></td>
                                <td>'.$data['mrdno'].'</td>
                                <td>'.$data['dateofbirth'].' & '.$data['ageyy'].'</td>
                                <td>'.$data['appointment_time'].'</td>
                                <td>'.$opdchargeamt.'</td>
                                <td>'.$doc.'</td>
                                <td>'.$waiting_time.'</td>
                                <td class="bgsts">'.$stat.'</td>
                              </tr>';
                          $sl2++;
                         
            }
            if($sl2>0)
            {
              $sl2=$sl2-1;
            }

            
        }
        $Response3 =$this->Dashboard_model->Patient_Status_Dash($docid,$curdate,3);
        if($Response3)
        {
            $sl3=1;
            
            $waiting_time=0;
            foreach($Response3 as $data)
            {
              $checkTime = strtotime($data['appointment_time']);
              $mrdno = strtotime($data['mrdno']);
              $patient_appointment_id=$data['patient_appointment_id'];
              $checkTime =date('H:i:s', $checkTime);
              $loginTime = strtotime($data['appointment_time']);
              $time1 = new DateTime($data['appointment_time']);
              $time2 = new DateTime(date('H:i:s'));
              $interval = $time1->diff($time2);
              $diff= $interval->format('%s second(s)');
              $patient_registration_id=$data['patient_registration_id'];
              $opd=$data['appointment_opd_charge_id'];
              $opdcharge=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->name;
              $amount=$grand_total=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->amount;
              $opdchargeamt=$opdcharge.'-'.$amount.',';
              $clrrow='';
              if($data['cancel_flag']==1)
              {
                $clrrow=' style="background:yellow"';
              }

                 $sqll2 = "select count(*) as cnt from patient_appointment  where 
               patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll2); 
                    $res1= $result_row1->result_array();
                    $cnt=$res1[0]['cnt'];
                    $new='';
                    if($cnt==1)
                    {
                      $new='<span class="badge badge-danger">New</span>';
                      $newclr="style='font-weight:bold;color:red;'";
                    }
                    else
                    {
                       $newclr="style='font-weight:bold;color:blue;'";
                    }

                    $sqll = "select doctors_registration.name as doctorname from patient_appointment inner join doctors_registration on patient_appointment.doctor_id=doctors_registration.doctors_registration_id where 
               patient_registration_id=$patient_registration_id  order by patient_appointment.patient_appointment_id DESC";
                    $result_row=$this->db->query($sqll); 
                    $res= $result_row->result_array ();
                    if($res)
                    {
                      $doc=$res[0]['doctorname'];
                    }
                    else
                    {
                      $doc='';
                    }
                    $stat='<p style="color:#fff;">Nill</p>';
                    $sqll1 = "select confirm_flag,optho_action,doc_action from examination where patient_appointment_id=$patient_appointment_id and patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll1); 
                    $res1= $result_row1->result_array ();
                    if($res1)
                    {
                      $confirm_flag=$res1[0]['confirm_flag'];
                      $doc_action=$res1[0]['doc_action'];
                      if($confirm_flag==0)
                      {
                        $optho_action=$res1[0]['optho_action'];
                        if($optho_action==0)
                        {
                          $stat='<p style="color:#fff;">Optometry inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Optometrists Completed</p>';
                        }
                      }

                      if($confirm_flag==1)
                      {
                        $doc_action=$res1[0]['doc_action'];
                        if($doc_action==0)
                        {
                          $stat='<p style="color:#fff;">Consultant Inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Consultant Completed</p>';
                        }
                      }
                    }
               
                    $nedcodcomtime=date('Y-m-d H:i:s');
                    $getresult_doctcom=$this->Dashboard_model->getlastcompdatetime($patient_registration_id,$patient_appointment_id);
                    if($getresult_doctcom)
                    {
                        if($getresult_doctcom[0]['doctor_completed_datetime'])
                        {
                          $nedcodcomtime=$getresult_doctcom[0]['doctor_completed_datetime'];
                        }
                    }

                        $billing_time=$data['adate'].' '.$checkTime;
                        $waiting_time= $this->find_date_diff($billing_time,$nedcodcomtime) ;

                       

                        $html3.='<tr>
                                <td>'.$sl3.'</td>
                                <td><c>'.$data['pateint_name'].' '.$new.'</c></td>
                                <td>'.$data['mrdno'].'</td>
                                <td>'.$data['dateofbirth'].' & '.$data['ageyy'].'</td>
                                <td>'.$data['appointment_time'].'</td>
                                <td>'.$opdchargeamt.'</td>
                                <td>'.$doc.'</td>
                                <td>'.$waiting_time.'</td>
                                <td class="bgsts">'.$stat.'</td>
                              </tr>';
                          $sl3++;
                         
            }
            if($sl3>0)
            {
              $sl3=$sl3-1;
            }
        }
        $Response4 =$this->Dashboard_model->Patient_Status_Dash($docid,$curdate,4);
        if($Response4)
        {
            $sl4=1;
            
            $waiting_time=0;
            foreach($Response4 as $data)
            {
              $checkTime = strtotime($data['appointment_time']);
              $mrdno = strtotime($data['mrdno']);
              $patient_appointment_id=$data['patient_appointment_id'];
              $checkTime =date('H:i:s', $checkTime);
              $loginTime = strtotime($data['appointment_time']);
              $time1 = new DateTime($data['appointment_time']);
              $time2 = new DateTime(date('H:i:s'));
              $interval = $time1->diff($time2);
              $diff= $interval->format('%s second(s)');
              $patient_registration_id=$data['patient_registration_id'];
              $opd=$data['appointment_opd_charge_id'];
              $opdcharge=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->name;
              $amount=$grand_total=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->amount;
              $opdchargeamt=$opdcharge.'-'.$amount.',';
              $clrrow='';
              if($data['cancel_flag']==1)
              {
                $clrrow=' style="background:yellow"';
              }

                 $sqll2 = "select count(*) as cnt from patient_appointment  where 
               patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll2); 
                    $res1= $result_row1->result_array();
                    $cnt=$res1[0]['cnt'];
                    $new='';
                    if($cnt==1)
                    {
                      $new='<span class="badge badge-danger">New</span>';
                      $newclr="style='font-weight:bold;color:red;'";
                    }
                    else
                    {
                       $newclr="style='font-weight:bold;color:blue;'";
                    }

                    $sqll = "select doctors_registration.name as doctorname from patient_appointment inner join doctors_registration on patient_appointment.doctor_id=doctors_registration.doctors_registration_id where 
               patient_registration_id=$patient_registration_id  order by patient_appointment.patient_appointment_id DESC";
                    $result_row=$this->db->query($sqll); 
                    $res= $result_row->result_array ();
                    if($res)
                    {
                      $doc=$res[0]['doctorname'];
                    }
                    else
                    {
                      $doc='';
                    }
                    $stat='<p style="color:#fff;">Nill</p>';
                    $sqll1 = "select confirm_flag,optho_action,doc_action from examination where patient_appointment_id=$patient_appointment_id and patient_registration_id=$patient_registration_id";
                    $result_row1=$this->db->query($sqll1); 
                    $res1= $result_row1->result_array ();
                    if($res1)
                    {
                      $confirm_flag=$res1[0]['confirm_flag'];
                      $doc_action=$res1[0]['doc_action'];
                      if($confirm_flag==0)
                      {
                        $optho_action=$res1[0]['optho_action'];
                        if($optho_action==0)
                        {
                          $stat='<p style="color:#fff;">Optometry inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Optometrists Completed</p>';
                        }
                      }

                      if($confirm_flag==1)
                      {
                        $doc_action=$res1[0]['doc_action'];
                        if($doc_action==0)
                        {
                          $stat='<p style="color:#fff;">Consultant Inprogress</p>';
                        }
                        else
                        {
                          $stat='<p style="color:#fff;">Consultant Completed</p>';
                        }
                      }
                    }
               
                    $nedcodcomtime=date('Y-m-d H:i:s');
                    $getresult_doctcom=$this->Dashboard_model->getlastcompdatetime($patient_registration_id,$patient_appointment_id);
                    if($getresult_doctcom)
                    {
                        if($getresult_doctcom[0]['doctor_completed_datetime'])
                        {
                          $nedcodcomtime=$getresult_doctcom[0]['doctor_completed_datetime'];
                        }
                    }

                        $billing_time=$data['adate'].' '.$checkTime;
                        $waiting_time= $this->find_date_diff($billing_time,$nedcodcomtime) ;

                       

                        $html4.='<tr>
                                <td>'.$sl4.'</td>
                                <td><c>'.$data['pateint_name'].' '.$new.'</c></td>
                                <td>'.$data['mrdno'].'</td>
                                <td>'.$data['dateofbirth'].' & '.$data['ageyy'].'</td>
                                <td>'.$data['appointment_time'].'</td>
                                <td>'.$opdchargeamt.'</td>
                                <td>'.$doc.'</td>
                                <td>'.$waiting_time.'</td>
                                <td class="bgsts">'.$stat.'</td>
                              </tr>';
                          $sl4++;
                         
            }
            if($sl4>0)
            {
              $sl4=$sl4-1;
            }
        }
        echo json_encode(array('msg' =>'success','dataview1'=>$html1,'cnt1'=>$sl1,'dataview2'=>$html2,'cnt2'=>$sl2,'dataview3'=>$html3,'cnt3'=>$sl3,'dataview4'=>$html4,'cnt4'=>$sl4,'error'=>'','error_message' =>''));
    }
    else 
    {
      $Response1 =$this->Dashboard_model->Patient_Status_Dash($docid,$curdate,$type);
    //  print_r($Response1);exit;
      if($Response1)
      {
          $sl1=1;
          
          $waiting_time=0;
          foreach($Response1 as $data)
          {
            $checkTime = strtotime($data['appointment_time']);
            $mrdno = strtotime($data['mrdno']);
            $patient_appointment_id=$data['patient_appointment_id'];
            $checkTime =date('H:i:s', $checkTime);
            $loginTime = strtotime($data['appointment_time']);
            $time1 = new DateTime($data['appointment_time']);
            $time2 = new DateTime(date('H:i:s'));
            $interval = $time1->diff($time2);
            $diff= $interval->format('%s second(s)');
            $patient_registration_id=$data['patient_registration_id'];
            $opd=$data['appointment_opd_charge_id'];
            $opdcharge=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->name;
            $amount=$grand_total=$this->db->get_where('opdcharge',"opdcharge_id=$opd")->row()->amount;
            $opdchargeamt=$opdcharge.'-'.$amount.',';
            $clrrow='';
            if($data['cancel_flag']==1)
            {
              $clrrow=' style="background:yellow"';
            }

               $sqll2 = "select count(*) as cnt from patient_appointment  where 
             patient_registration_id=$patient_registration_id";
                  $result_row1=$this->db->query($sqll2); 
                  $res1= $result_row1->result_array();
                  $cnt=$res1[0]['cnt'];
                  $new='';
                  if($cnt==1)
                  {
                    $new='<span class="badge badge-danger">New</span>';
                    $newclr="style='font-weight:bold;color:red;'";
                  }
                  else
                  {
                     $newclr="style='font-weight:bold;color:blue;'";
                  }

                  $sqll = "select doctors_registration.name as doctorname from patient_appointment inner join doctors_registration on patient_appointment.doctor_id=doctors_registration.doctors_registration_id where 
             patient_registration_id=$patient_registration_id  order by patient_appointment.patient_appointment_id DESC";
                  $result_row=$this->db->query($sqll); 
                  $res= $result_row->result_array ();
                  if($res)
                  {
                    $doc=$res[0]['doctorname'];
                  }
                  else
                  {
                    $doc='';
                  }
                  $stat='Nill';
                  $sqll1 = "select confirm_flag,optho_action,doc_action from examination where patient_appointment_id=$patient_appointment_id and patient_registration_id=$patient_registration_id";
                  $result_row1=$this->db->query($sqll1); 
                  $res1= $result_row1->result_array ();
                  if($res1)
                  {
                    $confirm_flag=$res1[0]['confirm_flag'];
                    $doc_action=$res1[0]['doc_action'];
                    if($confirm_flag==0)
                    {
                      $optho_action=$res1[0]['optho_action'];
                      if($optho_action==0)
                      {
                        $stat='<p style="color:red;">Optometry inprogress</p>';
                      }
                      else
                      {
                        $stat='<p style="color:green;">Optometrists Completed</p>';
                      }
                    }

                    if($confirm_flag==1)
                    {
                      $doc_action=$res1[0]['doc_action'];
                      if($doc_action==0)
                      {
                        $stat='<p style="color:red;">Consultant Inprogress</p>';
                      }
                      else
                      {
                        $stat='<p style="color:green;">Consultant Completed</p>';
                      }
                    }
                  }

                    $nedcodcomtime=date('Y-m-d H:i:s');
                    $getresult_doctcom=$this->Dashboard_model->getlastcompdatetime($patient_registration_id,$patient_appointment_id);
                    if($getresult_doctcom)
                    {
                        if($getresult_doctcom[0]['doctor_completed_datetime'])
                        {
                          $nedcodcomtime=$getresult_doctcom[0]['doctor_completed_datetime'];
                        }
                    }
             
                      $billing_time=$data['adate'].' '.$checkTime;
                      $waiting_time= $this->find_date_diff($billing_time,$nedcodcomtime) ;

                     

                      $html1.='<tr>
                              <td>'.$sl1.'</td>
                              <td><c>'.$data['pateint_name'].' '.$new.'</c></td>
                              <td>'.$data['mrdno'].'</td>
                              <td>'.$data['dateofbirth'].' & '.$data['ageyy'].'</td>
                              <td>'.$data['appointment_time'].'</td>
                              <td>'.$opdchargeamt.'</td>
                              <td>'.$doc.'</td>
                              <td>'.$waiting_time.'</td>
                              <td>'.$stat.'</td>
                            </tr>';
                        $sl1++;
                       
          }
          if($sl1>0)
          {
            $sl1=$sl1-1;
          }

          echo json_encode(array('msg' =>'success','dataview1'=>$html1,'cnt1'=>$sl1,'error'=>'','error_message' =>''));
      }
      else {
        
        echo json_encode(array('msg' =>'success','dataview1'=>'','cnt1'=>0,'error'=>'','error_message' =>''));
      }
      
    }
  }
  public function find_date_diff($fromdate,$todate) 
  {
     $date1=strtotime($fromdate);
     $date2=strtotime($todate);
     // Formulate the Difference between two dates
     $diff = abs($date1 - $date2); 

     $years = floor($diff / (365*60*60*24)); 


     $months = floor(($diff - $years * 365*60*60*24)
                                    / (30*60*60*24)); 

     $days = floor(($diff - $years * 365*60*60*24 - 
                  $months*30*60*60*24)/ (60*60*24));

     $hours = floor(($diff - $years * 365*60*60*24 
            - $months*30*60*60*24 - $days*60*60*24)
                                        / (60*60)); 


     $minutes = floor(($diff - $years * 365*60*60*24 
              - $months*30*60*60*24 - $days*60*60*24 
                               - $hours*60*60)/ 60); 

     $seconds = floor(($diff - $years * 365*60*60*24 
              - $months*30*60*60*24 - $days*60*60*24
                     - $hours*60*60 - $minutes*60)); 
     $return="";
     if($years>0)
     {
        $return.="$years Year,";
     }
     if($months>0)
     {
       $return.="$months Month,"; 
     }
     if($days>0)
     {
       $return.="$days Days,";   
     }
     $hours=$hours;
     $minutes=$minutes;
      $return.="$hours:$minutes";
      return $return;
   
 }
}
