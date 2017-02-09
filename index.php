<?php
class Plan{
    function get($app,$params)
    {
        $db=new \DB\Jig('plans/',\DB\Jig::FORMAT_JSON);
        $mapper=new \DB\Jig\Mapper($db,'plans.json');
        $plans=$mapper->find(Array('@id',$params['number']));
        $resault=[];
        foreach($plans as $k=>$plan){
            foreach($l as $a=>$b){
                if($a!='id' && $k["id"]==$params["id"])
                {
                    $resault[$a]=$b;
                }
            }
        }
        echo json_encode($resault);
    }

    function post($app,$params)
    {
        $data=json_decode($app['BODY']);
        echo json_encode($data);
        $db=new \DB\Jig('plans/',\DB\Jig::FORMAT_JSON);
        $mapper=new \DB\Jig\Mapper($db,'plans.json');

        $mapper->id=$data->id; //SM azonosító
        $mapper->days=$data->days; //nap
        $mapper->shiftnum=$data->shiftnum; //szak azonosító
        $mapper->amount=$data->amount; // tervezett darsb szám
        $mapper->save();

        echo "OK";

        @unlink($data);
        @unlink($mapper);
        @unlink($db);
    }

    function put($app,$params)
    {
        $data=json_decode($app['BODY']);
        $db=new \DB\Jig('plans/',\DB\Jig::FORMAT_JSON);
        $plan=$mapper->load(Array('@id=?',$params['id']));

        /*$plan->id=$data->id;
        $plan->days=$data->days;
        $plan->shiftnum=$data->shiftnum;*/
        $plan->amount=$data->amount;
        $plan->save();

        echo "OK";

        @unlink($data);
        @unlink($mapper);
        @unlink($db);
        @unlink($plan);
    }

    function delete($app,$params)
    {
        $db=new \DB\Jig('plans/',\DB\Jig::FORMAT_JSON);
        $mapper= new \DB\Jig\Mapper($db,'plans.json');
        $plan=$mapper->find(Array('@id=?',$params['id']));
        $plan[0]->erase();

        echo "OK";

        @unlink($mapper);
        @unlink($db);
        @unlink($plan);
    }
}

$app=require('../f3lib/base.php');
$app->map('/plan/@id','Plan');

$app->route('GET /plns',function($app){
    $data=file_get_contents('plans/plans.json');
    $data=json_decode($data);

    $resault=[];
    foreach($data as $k->$v){
        array_push($resault,$v);
    }
    echo json_encode($resault);
});
$app->run();
?>