<?php 

class MEDOOHelper extends MedooOrm{



    public static function query($sql, $params=[],$isObj = false) {
        $req = parent::openLink()->query($sql, $params);
        if($isObj) return $req->fetchAll(PDO::FETCH_OBJ);
        return $req->fetchAll(PDO::FETCH_ASSOC);;
    }
    public static function queryOne($sql, $params=[],$isObj = false) {
        $req = parent::openLink()->query($sql, $params);
        if($isObj) return $req->fetch(PDO::FETCH_OBJ);
        return $req->fetch(PDO::FETCH_ASSOC);;
    }

    public static function selectAll($partnerID,$table, $columns, $where = []) {
        $req = parent::openLink($partnerID)->select($table, $columns, $where);
        return $req;
    }
    public static function selectAllOrderBy($table, $columns, $order = []) {
        $req = parent::openLink()->select($table, $columns, ["ORDER" => $order]);
        return $req;
    }

    public static function selectOne($table, $columns, $where = []) {
        $req = parent::openLink()->get($table, $columns, $where);
        return $req;
    }

    public static function insert($partnerID,$table,$data) {
        parent::openLink($partnerID)->insert($table, $data);
        return parent::openLink()->id();
    }
    
    public static function update($table, $data, $where) {
        $req = parent::openLink()->update($table, $data, $where)->rowCount();
        return $req;
    }

    public static function delete($table, $where) {
        $req = parent::openLink()->delete($table, $where)->rowCount();
        return $req;
    }

    public static function count($partnerID,$table, $columns = "*", $where = []) {
        $count = parent::openLink($partnerID)->count($table, $columns, $where);
        return $count;
    }

    public static function medooService() {
        return  parent::getLink();
    }
    
}