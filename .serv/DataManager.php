<?php
/**
 * Created by PhpStorm.
 * User: Galadima
 * Date: 3/24/2019
 * Time: 11:22 AM
 */

require_once "dbconnect.php";

class DataManager
{


    /**
     * @return PdoWrapper
     */
    public static function connect()
    {
        return try_db_connect();
    }

    public static function insert($table,array $fields,array $values)
    {
        $_fields = implode(",",$fields);
        $qm = [];
        foreach ($fields as $field){
            $qm []="?";
        }
        $qm = implode(",",$qm);
        $query = "INSERT INTO $table ( $_fields) VALUES ($qm)";
        $db = self::connect();
        $stmt = $db->prepare($query);
        $stmt->execute($values);
        return $db->lastInsertId();
    }

    /**
     * @param $table
     * @param $values
     * @param string $where
     * @return int
     */
    public static function update($table, $values, $where="")
    {
        $_where_ = $where;
        if(!empty($where) || $where !=""){
            $_res_ = self::prepareWhere($where);
            $_where_ = $_res_[0];
            $_binds_ = $_res_[1];
        }
        $_update_ = self::prepareUpdate($values);
        $query = "UPDATE $table SET ".$_update_." ".($_where_ == ""?"":" WHERE $_where_");
        $db = self::connect();
        $stmt = $db->prepare($query);
        if( isset($values) ){
            $count = 0;
            foreach ($values as $key=>$value){
                $stmt->bindValue(":paramU$count", $value);
                $count++;
            }
        }
        if( isset($_binds_) ){
            foreach ($_binds_ as $key=>$value){
                $stmt->bindValue(":".$key, $value);
            }
        }

        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * @param $values
     * @return bool|string
     */
    public static function prepareUpdate($values)
    {
        $_values_ = "";$count=0;
        foreach ($values as $key=>$value){
            $_values_ .= "$key = :paramU$count ,";
            $count++;
        }
        return substr($_values_,0,-1);

    }
	/**
     * @param raw SQL
     * @return array|stdClass
     */
    public static function rawQuery($query)
    {
        $db = self::connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
        return self::toObject($stmt->fetchAll(PDO::FETCH_ASSOC));

    }

    /**
     * @param $table
     * @param string $select
     * @param string $where
     * @param array $join
     * @return array|stdClass
     */
    public static function query($table, $select="*", $where="", $join=[],$orderBy="")
    {
        try{
            $_select_ = $select==""?"*":$select;$_where_ = $where;$_join_="";$_order_by_ = $orderBy==""?"":"ORDER BY $orderBy";
            if(!empty($select) || $select !="*")
                $_select_ = self::prepareSelect($select);
            if(!empty($where) || $where !=""){
                $_res_ = self::prepareWhere($where);
                $_where_ = $_res_[0];
                $_binds_ = $_res_[1];
            }
            if( !empty($join) ){
                $_j_ = self::prepareJoin($join);
//                var_dump($_j_);
                $_join_ = $_j_[0];
                $_jbinds_=$_j_[1];
            }
            $query = "SELECT $_select_ FROM $table A  $_join_ ".($_where_ == ""?"":" WHERE $_where_ $_order_by_");
//            echo $query;
            $db = self::connect();
            $stmt = $db->prepare($query);
            if( isset($_binds_) ){
                foreach ($_binds_ as $key=>$value){
                    $stmt->bindValue(":".$key, $value);
                }
            }
            if(isset($_jbinds_)){
                foreach ($_jbinds_ as $key=>$value){
                    $stmt->bindValue(":".$key, $value);
                }
            }
//         var_dump($stmt->debugDumpParams());
            $resultt = $stmt->execute();
//            $resultt->queryString;
            return self::toObject($stmt->fetchAll(PDO::FETCH_ASSOC));
        }catch (PDOException $e){
            echo  "<div class='alert alert-warning'>{$e->getMessage()}</div>";
            return [];
        }

    }

    /**
     * @param $join
     * @return int
     */
    public static function prepareJoin($join )
    {
        if (is_array($join)){
            $_join_ = " ";
            $binds = [];
            $alphabets = range('B','Z');
            if (is_array(pos($join))) {
                $count = 0;
                foreach ($join as $j){
                    $_j_ = self::joinType($j[0]);
                    $_join_ .= $_j_[1]." ".$_j_[0]." AS ".$alphabets[$count]." ON";
                    $where = $j[1];
                    if(!empty($where) || $where !=""){
                        $_res_ = self::prepareWhere($where,"J");
                        $_where_ = $_res_[0];
                        $_binds_ = $_res_[1];
                    }
                    $_join_ .= ($_where_ == ""?"":"$_where_")." ";
                    $binds = array_merge($binds,$_binds_);
                    $count++;
                }
                return [$_join_,$binds];
            } else {
                return array_keys($join);
            }
        }
        return $join;
    }

    /**
     * @param $table
     * @return array
     */
    public static function joinType($table)
    {
        $char = substr($table,0,1);
        switch ($char){
            case "<":return [substr($table,1),"LEFT JOIN "];break;
            case ">":return [substr($table,1),"RIGHT JOIN "];break;
            default:return [substr($table,0),"JOIN "];break;
        }
    }

    /**
     * @param array $array
     * @return bool
     */
    public static function has_string_keys(array $array)
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

    /**
     * @param $selects
     * @return bool|string
     */
    public static function prepareSelect($selects)
    {

        $select__ = " ";
        if (is_array($selects)) {

            if (self::has_string_keys($selects)) {
                foreach ($selects as $key => $value) {
                    if (isset($key) && !is_array($value))
                        $select__ .= " " . self::selectSting([$key, $value]) . ",";
                    else
                        $select__ .= " " . self::selectSting($value) . ",";
                }
            } else {
                foreach ($selects as $select) {
                    $select__ .= " " . self::selectSting($select) . ",";
                }
            }

        } else {
            $select__ = $selects . ",";
        }

        return substr($select__, 0, -1);
    }

    /**
     * @param $item
     * @return string
     */
    public static function selectSting($item)
    {
        if (is_array($item)) {
            return " " . $item[0] . " AS " . $item[1];
        }
        return " " . $item;
    }

    /**
     * @param $item
     * @param string $condition
     * @param string $index
     * @return array|string
     */
    public static function whereSting($item, $condition="", $index="0")
    {
        $condition_ = $condition;
        if( $condition == "&" ) $condition_ ="AND";
        if( $condition == "|" ) $condition_ ="OR";

        if ( is_array( $item ) ) {

            if( count( $item ) == 3 ){
                return ["query"=>" $condition_ " . $item[0] . " ".$item[1]." :param$index" ,"value"=>$item[2]];
            }elseif ( count( $item ) == 2 ){
                if( is_array( $item[1] ) && !is_numeric( $item[0] )){
                    $inString = "";
                    foreach ($item[1] as $it){
                        $inString .= "$it ,";
                    }
                    $inString = substr($inString,0,-1);

                    return ["query"=>" $condition_ " . $item[0] . " IN ( :param$index ) ","value"=>$inString];

                }elseif(is_array( $item[1] ) && is_numeric( $item[0] ) ){
                    if( count($item[1] ) > 2){
                        return ["query"=>" $condition_ " . $item[1][0] ." ".$item[1][1] . " :param$index","value"=>$item[1][2]];
                    }else{
                        return ["query"=>" $condition_ " . $item[1][0] ." = :param$index","value"=>$item[1][1]];
                    }
                }
                else{
                    return ["query"=>" $condition_ " . $item[0] . " = :param$index","value"=>$item[1]];
                }
            }

        }
        return " $condition_ " . $item;
    }


    /**
     * @param $wheres
     * @param string $paramSalt
     * @return array
     */
    public static function prepareWhere($wheres, $paramSalt="")
    {

        $where__ = " ";$param__=[];
        if (is_array($wheres)) {

            if (self::has_string_keys($wheres)) {
                $count = 0;$paramK = 0;
                foreach ($wheres as $key => $value) {
                    $k = $key;$c = "&";
                    if( $key[0] == "&" || $key[0] == "|"){
                        $k = substr($key,1);
                        $c = $key[0];
                    }
                    if (isset($key) && !is_array($value)){
                        $result = self::whereSting([$k, $value],($count > 0?$c:""),$count);
                        $where__ .= " " . $result["query"];
                        $param__["param$paramSalt$count"] =  $result["value"];
                    }elseif (!is_numeric($key) && is_array($value)){
                        $result = self::whereSting([$k, $value],($count > 0?$c:""),$count);
                        $where__ .= " " . $result["query"];
                        $param__["param$paramSalt$count"] =  $result["value"];
                    }
                    else{
                        $result = self::whereSting([$k, $value],($count > 0?$c:""),$count);
                        $where__ .= " " . $result["query"];
                        $param__["param$paramSalt$count"] =  $result["value"];
                    }

                    $count++;
                }
            } else {
                foreach ($wheres as $select) {
                    $where__ .= " " . self::whereSting($select) ;
                }
            }

        } else {
            $where__ = $wheres;
        }

        return [$where__,$param__];
    }

    /**
     * @param $array
     * @return array|stdClass
     */
    public static function toObject($array)
    {

        if( self::has_string_keys($array) ){
            $obj = new stdClass();
            foreach ($array as $key=>$value){
                $obj->$key = $value;
            }
            return $obj;
        }
        $objArray = [];
        foreach ($array as $a){
            $objArray[] = self::toObject($a);
        }
        return $objArray;

    }


    public static function delete($table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";
//        var_dump($query);
        $db = self::connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
