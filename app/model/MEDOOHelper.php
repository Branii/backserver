<?php 

class MEDOOHelper extends MedooOrm{

    public static function query($sql, $params=[]) {
        $req = parent::openLink()->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
        return $req;
    }

    public static function selectAll($table, $columns, $where = []) {
        $req = parent::openLink()->select($table, $columns, $where);
        return $req;
    }

    public static function selectOne($table, $columns, $where = []) {
        $req = parent::openLink()->get($table, $columns, $where);
        return $req;
    }

    public static function insert($table,$data) {
        parent::openLink()->insert($table, $data);
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

    public static function count($table, $columns = "*", $where = []) {
        $count = parent::openLink()->count($table, $columns, $where);
        return $count;
    }
    
}