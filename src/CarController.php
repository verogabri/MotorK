<?php

namespace Motork;


use phpDocumentor\Reflection\Types\This;
use phpDocumentor\Reflection\Types\Self_;

class CarController
{
    
    protected $db;
    
    
    /**
     * Index Action
     *
     * This should contain the list of cars.
     */
    public function getIndex()
    {
        $cars = json_decode(file_get_contents('http://localhost:8889/api.php/search'));
        $cars = $cars->data;
        
        
        include CONFIG_VIEWS_DIR . '/index.php';
        
        return 1;
    }

    /**
     * Privacy Action
     * this is the page with the declaration about personal data etc
     */
    public function getPrivacy()
    {
        
        include CONFIG_VIEWS_DIR . '/privacy.php';
    }
    
    
    public function test()
    {
        
        return 'una stringa';
    }
    
    /**
     * Detail Action
     *
     * This should contain the car's detail and the form.
     */
    public function getDetail($id_car="")
    {
        
        if($id_car!="")  $car = json_decode(@file_get_contents('http://localhost:8889/api.php/detail/'.$id_car));
        else $car = "";
        
        // prepare data for db and the form
        $dataRequest = array();
        $dataRequest['email'] = "";
        $dataRequest['name'] = "";
        $dataRequest['surname'] = "";
        $dataRequest['phone'] = "";
        $dataRequest['zip'] = "";
        
        if(isset($_POST['privacy']) && $_POST['privacy']=='Y'){
            
            
            $dataRequest['email'] = isset($_POST['email'])?$_POST['email']:"";
            $dataRequest['name'] = isset($_POST['name'])?$_POST['name']:"";
            $dataRequest['surname'] = isset($_POST['surname'])?$_POST['surname']:"";
            $dataRequest['phone'] = isset($_POST['phone'])?$_POST['phone']:"";
            $dataRequest['zip'] = isset($_POST['zip'])?$_POST['zip']:"";
            
            $resultRequest = $this->saveRequest($dataRequest,$id_car);
            
        }
        
        // if there is a car for the id passed
        if(isset($car->status) && $car->status==200){
            
            $tags = (array)$car->data->tags;
            
            // $similarCars = $this->searchSimilarCars_by_Segment($car);
            $similarCars = $this->searchSimilarCars_by_Distance($car);
            
            
            include CONFIG_VIEWS_DIR . '/detail.php';
            
        } else { // or no car with that id
            
            include CONFIG_VIEWS_DIR . '/detail_nocar.php';
        }
        
    }

    
    /**
     * search engine to select similar car
     * based on the measure of the distance
     * @param object $baseCar
     * @return boolean|array
     */
    public function searchSimilarCars_by_Distance($baseCar="")
    {
        if($baseCar=="") return false;
        
        $baseCar_tags =  (array)$baseCar->data->tags;
        
        $cars = json_decode(file_get_contents('http://localhost:8889/api.php/search'));
        $cars = $cars->data;
        
        $similarcar = array();
        
        // do somethig more
        foreach ($cars as $car){
            
            if($car->attrs->carId == $baseCar->data->attrs->carId) continue;
            
            $car_tags =  (array)$car->tags;
            
            // distance
            $_distance = 0;
            
            if($car_tags['Internal space'] != $baseCar_tags['Internal space']) $_distance = $_distance+1;
            
            if($car_tags['Segment'] != $baseCar_tags['Segment']) $_distance = $_distance+1;
            
            if($car_tags['Fuel type'] != $baseCar_tags['Fuel type']) $_distance = $_distance+1;
            
            if($car_tags['Look'] != $baseCar_tags['Look']) $_distance = $_distance+1;
            
            // distance by price
            $_base_price = $this->valuePercentile($baseCar_tags['Price']);
            $_car_price = $this->valuePercentile($car_tags['Price']);
            
           if($_base_price!=false && $_car_price!=false){
                $_pow_price = pow( abs($_base_price-$_car_price), 2);
                $_distance = $_distance+$_pow_price;
            }
            
            $car->distance = sqrt($_distance);
            
            $similarcar[] = $car;
            
        }
        
        // sort from the closest to the farthest
        usort($similarcar,"self::ordinamentoObj");
        
        return $similarcar;
        
    }
    
    private function valuePercentile($percentile)
    {
        $_value = "";
        $_tmp = explode(" ", $percentile);
        
        if(isset($_tmp[0])) $_value = (int)trim($_tmp[0],' %');

        if(is_int($_value)) return $_value;
        else return false;
        
    }
    
    private function ordinamentoObj($a, $b)
    {
        $fld="distance";
        
        $al = $a->$fld;
        $bl = $b->$fld;
        
        if ($al == $bl) return 0;
        $res= ($al > $bl) ? +1 : -1;
        
        //if ($this->ordinamento_ascendente) $res=-1*$res;
        
        return $res;
    }
    
    /**
     * search engine to select similar car
     * base only on segment attribute
     * @param object $baseCar
     * @return boolean|array
     */
    public function searchSimilarCars_by_Segment($baseCar="")
    {
        if($baseCar=="") return false;
        
        $cars = json_decode(file_get_contents('http://localhost:8889/api.php/search'));
        $cars = $cars->data;
        
        $similarcar = array();
        
        // do somethig more
        foreach ($cars as $car){
            
            if($car->attrs->carId == $baseCar->data->attrs->carId) continue;
            
            if($car->tags->Segment == $baseCar->data->tags->Segment){
                $similarcar[] = $car;
            }
        }
        
        return $similarcar;
        
    }
    
    
    public function saveForm() {
        
        // prepare data for db and the form
        $resultRequest = false;
        $result = array(
            'error' => 0,
            'msg' => ""
        );
      
        if(isset($_POST['privacy']) && $_POST['privacy']=='Y'){
            $dataRequest = array();
            $dataRequest['email'] = isset($_POST['email'])?$_POST['email']:"";
            $dataRequest['name'] = isset($_POST['name'])?$_POST['name']:"";
            $dataRequest['surname'] = isset($_POST['surname'])?$_POST['surname']:"";
            $dataRequest['phone'] = isset($_POST['phone'])?$_POST['phone']:"";
            $dataRequest['zip'] = isset($_POST['zip'])?$_POST['zip']:"";
            
            $id_car = isset($_POST['idcar'])?$_POST['idcar']:"";
            
            $resultRequest = $this->saveRequest($dataRequest,$id_car);
            
            if($resultRequest==false){
                $result = array(
                    'error' => 20,
                    'msg' => "DB error, impossible to save request"
                );
            }
        } else {
            
            $result = array(
                'error' => 10,
                'msg' => "Data request was missing"
            );
            
        }
       
        
        header("Content-Type:application/json");
        header("HTTP/1.1 200");
        echo json_encode($result, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        flush();
        
        die();
        
        
    }
    
    /**
     * Check request data and save to db
     * @param array $data
     * @return boolean
     */
    public function saveRequest($data,$id_car=""){
        
        $result = true;
        
        // check data
        if(isset($data['email']) && $data['email']!=""){
            if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)==false) $result = false;
        } else {
            $result = false;
        }
        
        if(isset($data['name']) && $data['name']=="") $result = false;

        if(isset($data['surname']) && $data['surname']=="") $result = false;
       
        if(isset($data['phone']) && $data['phone']=="") $result = false;
        
        if(isset($data['zip']) && $data['zip']=="") $result = false;
        
        if( $id_car=="") $result = false;
        
        
        if($result){
            
            $InsertData = date('Y-m-d H:i:s');
            
            // all data is ok then save them in db
            $query = "INSERT INTO Leads (Name, Lastname, Email, Phone, Cap, Privacy, CarId, InsertData) VALUES (:name, :surname, :email, :phone, :zip, '1', :idcar, '".$InsertData."')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $data['name']); //, $this->db::PARAM_STR);
            $stmt->bindParam(':surname', $data['surname']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':zip', $data['zip']);
            $stmt->bindParam(':idcar', $id_car);
            
            $res = $stmt->execute();
            
            if($res==false) $result = false;
           
        }
        
        return $result;
        
    }
    
    /**
     * return all leads in a json format
     * 
     */
    public function getLeads()
    {
        
        $stmt = $this->db->prepare('SELECT Name, Lastname, Email, Phone, Cap, Privacy, CarId, InsertData FROM Leads;');
        $stmt->execute();
        
        $rows = $stmt->fetchAll();
        
        $leads = array();
        
        //foreach($rows as $row){
        foreach ($rows as $row){
            $lead = array();
            foreach($row as $key => $value) {
                if(is_numeric($key)) continue;  // it needs to filter double entry, maybe there is a better solution but I'm not go round with SQLite so often
                $lead[$key] = $value;
            }
            $leads[]=$lead;
                
        }
        
        header("Content-Type:application/json");
        header("HTTP/1.1 200");
        echo json_encode($leads, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        flush();
        
        die();
        
    }
    
    
    /**
     * @return CarController
     */
    public static function create()
    {
        return new self();
        
    }
    
    /**
     * set attributes db
     * @param object $db
     */
    public function setDB($db)
    {
        $this->db = $db;
        
    }
    /**
     * return attribute db
     * @return object
     */
    public function getDB()
    {
        return $this->db;
        
    }
}