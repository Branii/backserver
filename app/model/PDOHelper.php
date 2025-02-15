<?php 

class PDOHelper  {

    public static function Executequery($sql,$params = []) {
        $req = (new Database)::openLink()->prepare($sql);
        $req->execute($params);
        (new Database)::closeLink();
        return $req;
    }

    public static function selectAll($sql,$params = []) {
        $req = self::Executequery($sql,$params);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function selectOne($sql,$params = []) {
        $req = self::Executequery($sql,$params);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($sql,$params = []) {
        $req = self::Executequery($sql,$params);
        return $req->rowCount();
    }
    
    public static function update($sql,$params = []) {
        $req = self::Executequery($sql,$params);
        return $req->rowCount();
    }

    public static function delete($sql,$params = []) {
        $req = self::Executequery($sql,$params);
        return $req->rowCount();
    }
    
}