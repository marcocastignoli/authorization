<?php

namespace marcocastignoli\authorization;

use Illuminate\Database\Eloquent\Model;

class AuthorizationScopes extends Model {

    function scopeEntity($query, $type=false){
        switch ($type) {
            case 'my':
                if (is_array($this->own)) {
                    $user_property=$this->own[1];
                    $query=$query->where($this->own[0], "=", \Auth::user()->$user_property);
                } else {
                    $query=$query->where($this->own, "=", \Auth::user()->id);
                }

                break;
            case '*':
            default:
                break;
        }
        return $query;
    }

    public function scopeShow($query, $type=false) {
        $auth=\Auth::user()->auth;
        $reflect = new \ReflectionClass($this);
        $object=$reflect->getShortName();
        $method="show";
        $query=$query->entity($type);
        $select=array();
        if ($type) {
            $fields = \DB::table('authorizations')
                ->where("auth", "=", $auth)
                ->where("object", "=", $object)
                ->where("method", "=", $method)
                ->where("entity", "=", $type)
                ->pluck("field");
            foreach ($fields as $key => $value) {
                $select[]=$value;
            }
            if (in_array("*", $select)) {
                $select="*";
            }
        } else {
            $select="*";
        }
        if (empty($select)) {
            abort(403, 'Unauthorized action.');
        }
        return $query->select($select);
    }

    public function scopePost($query, $type=false, $parameters){
        $auth=\Auth::user()->auth;
        $reflect = new \ReflectionClass($this);
        $object=$reflect->getShortName();
        $method="post";
        $query=$query->entity($type);
        $select=array();
        if ($type) {
            $fields = \DB::table('authorizations')
                ->where("auth", "=", $auth)
                ->where("object", "=", $object)
                ->where("method", "=", $method)
                ->where("entity", "=", $type)
                ->where(function($query) use ($parameters){
                    $query->whereIn('field', array_keys($parameters));
                    $query->orWhere('field', "=", "*");
                })
                ->pluck("field");
            if (!in_array("*", $fields->toArray())) {
                foreach ($fields as $key => $value) {
                    if (key_exists($value,$parameters)) {
                        $select[$value]=$parameters[$value];
                    }
                }
            } else {
                $select=$parameters;
            }
        } else {
            $select=$parameters;
        }
        if (empty($select)) {
            abort(403, 'Unauthorized action.');
        }
        return $query->update($select);
    }

    public function scopePut($query, $type=false, $parameters){
        $auth=\Auth::user()->auth;
        $reflect = new \ReflectionClass($this);
        $object=$reflect->getShortName();
        $method="put";
        $select=array();
        if ($type) {
            $fields = \DB::table('authorizations')
                ->where("auth", "=", $auth)
                ->where("object", "=", $object)
                ->where("method", "=", $method)
                ->where("entity", "=", $type)
                ->where(function($query) use ($parameters){
                    $query->whereIn('field', array_keys($parameters));
                    $query->orWhere('field', "=", "*");
                })
                ->pluck("field");
            if (!in_array("*", $fields->toArray())) {
                foreach ($fields as $key => $value) {
                    if (key_exists($value,$parameters)) {
                        $select[$value]=$parameters[$value];
                    }
                }
            } else {
                $select=$parameters;
            }
        } else {
            $select=$parameters;
        }
        if (empty($select)) {
            abort(403, 'Unauthorized action.');
        }
        return $query->insert($select);
    }

    public function scopeDel($query, $type=false, $id=null){
        $auth=\Auth::user()->auth;
        $reflect = new \ReflectionClass($this);
        $object=$reflect->getShortName();
        $method="delete";
        $query=$query->entity($type);
        if ($type) {
            $fields = \DB::table('authorizations')
                ->where("auth", "=", $auth)
                ->where("object", "=", $object)
                ->where("method", "=", $method)
                ->where("entity", "=", $type)
                ->where('field', "=", "*")
                ->pluck("field");
            if (!in_array("*", $fields->toArray())) {
                abort(403, 'Unauthorized action.');
            }
        }
        return $query->where("id", $id)->delete();
    }

}
