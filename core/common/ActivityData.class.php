<?php
/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2008 Nabeel Shahzad
 * For more information, visit www.phpvms.net
 *	Forums: http://www.phpvms.net/forum
 *	Documentation: http://www.phpvms.net/docs
 *
 * phpVMS is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Nabeel Shahzad
 * @copyright Copyright (c) 2008, Nabeel Shahzad
 * @link http://www.phpvms.net
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */
 
 class ActivityData extends CodonData {
    
 
    /**
     * ActivityData::getActivity()
     * 
     * @param integer $count
     * @return void
     */
    public static function getActivity($limit = 10, $start = '') {
        
        $sql = "SELECT p.*, a.*
				FROM `".TABLE_PREFIX."activityfeed` a
				INNER JOIN `".TABLE_PREFIX."pilots` p ON p.pilotid=a.pilotid ";

        $sql .= DB::build_where(array());
        $sql .= ' ORDER BY `id` DESC';

        if (strlen($limit) != 0) {
            $sql .= ' LIMIT ' . $limit;
        }

        if (strlen($start) != 0) {
            $sql .= ' OFFSET ' . $start;
        }

        $ret = DB::get_results($sql);
        return $ret;
        
    }
    
    
    /**
     * ActivityData::addActivity()
     * 
     * @param mixed $params
     * @return void
     */
    public static function addActivity($params) {
        
        $params = array_merge(array(
            'pilotid' => '',
            'type' => '',
            'refid' => '',
            'message' => '',
        ), $params);
    
        $sql = 'INSERT INTO `'.TABLE_PREFIX.'activityfeed`
                (`pilotid`, `refid`, `type`, `message`, `submitdate`)
                VALUES
                ('.$params['pilotid'].','.$params['refid'].','.$params['type']
                  .',\''.DB::escape($params['message']).'\', NOW())';
        
        return DB::query($sql);
    }
 
 
    public static function readTwitter() {
        
        
        
    }
 
 }
 
 
 
 
 
 