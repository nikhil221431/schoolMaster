<?php
if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );
class School_model extends CI_Model
{

    public function registerSumbit($username, $email, $password){

        $data  = array(
                    'username'            => $username,
                    'email'               => $email,
                    'password'            => md5($password)
                );
        $queryOpt = $this->db->insert( 'user', $data );

        $result = new stdClass();

        if(!$queryOpt) {

            $result->output = "FALSE";
            $result->message = "Unable to create user. Try again.";
        }
        else {

            $result->output = "TRUE";
            $result->message = "User successfully registered";
        }

        return $result;
    }

    public function loginSumbit($email, $password){

        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
   		$query = $this->db->get('user');

        $result = new stdClass();

        if($query->num_rows() > 0){

            $userInfo = $query->row();
            $newdata  = array(
                            'userid'    => $userInfo->id,
                            'username'  => $userInfo->username,
                            'useremail' => $userInfo->email
                        );
            $this->session->set_userdata( $newdata );
            
            $result->output = "TRUE";
            $result->message = "User Successfully Login";
        }
        else {

            $result->output = "False";
            $result->message = "Please Try agein";
        }

        return $result;
    }

    public function schoolinfo($name){

        if($name != "") {

            $this->db->like('name', trim($name));
        }

        // $this->db->where('created_by', $this->session->userdata('userid'));
        $this->db->order_by("name", "asc");
        $result = $this->db->get('school')->result();
        return $result;
    }

    public function createschoolsave($schoolName, $schoolLocation){

        $data  = array(
                    'name'        => $schoolName,
                    'location'    => $schoolLocation,
                    'created_by'  => $this->session->userdata('userid')
                );
        $queryOpt = $this->db->insert( 'school', $data );

        if(!$queryOpt) {

            return  0;
        }
        else {

            return  1;
        }
    }

    public function editschoolinfo($schoolId){

        $this->db->where('id', $schoolId);
        $result = $this->db->get('school')->row();
        return $result;
    }

    public function editschoolsave($schoolId, $schoolName, $location){

        $data = array(
                'name'         => $schoolName,
                'location'     => $location,
                'modify_by'    => $this->session->userdata("userid")
            );

        $this->db->where('id', $schoolId);
        $query = $this->db->update('school', $data);

        if(!$query){

            return  0;
        }
        else{

            return  1;
        }
    }

    public function deleteschooldata($schoolId){

        $this->db->where('id', $schoolId);
        $query = $this->db->delete('school');

        $result = new stdclass();

        if(!$query){

            $result->message = "Unable to delete record. Please try again.";
            $result->output  = "FALSE";
        }
        else{

            $result->message = "record successfuly deleted";
            $result->output  = "TRUE";
        }

        return $result;
    }
}//Welcome_model end
?>