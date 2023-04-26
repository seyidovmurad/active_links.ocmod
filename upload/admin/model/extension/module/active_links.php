<?php
    class ModelExtensionModuleActiveLinks extends Model {

        public function add($data) {
            $this->db->query("INSERT INTO ". DB_PREFIX . "active_links SET html_id = '". 
                                $this->db->escape($data['html_id']) . "', 
                                icon = '". $this->db->escape($data['icon']) . "', 
                                name = '". $this->db->escape($data['name']) . "', 
                                href = '". $this->db->escape($data['href']) . "', 
                                status = ". (int)$data['status'] . ";");
        }

        public function getList($data = array()) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "active_links` (
                `active_links_id` int(11) NOT NULL AUTO_INCREMENT,
                `html_id` varchar(50),
                `icon` varchar(100),
                `name` varchar(50),
                `href` varchar(250),
                `parent_id` int(11) NULL,
                `status` tinyint(1) NOT NULL,
                PRIMARY KEY (`active_links_id`),
                UNIQUE KEY `idnew_table_UNIQUE` (`active_links_id`),
                CONSTRAINT `SelfKey` FOREIGN KEY (`parent_id`) REFERENCES `".DB_PREFIX."active_links` (`active_links_id`) ON DELETE NO ACTION ON UPDATE NO ACTION)"
            );
            
            $sql = "SELECT * FROM ". DB_PREFIX. "active_links ORDER BY name ASC";

            if (isset($data['start']) && isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }
                
                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }	
            
                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }	
            
            $query = $this->db->query($sql);
     
            return $query->rows;

        }

        public function getById($id) {
            $sql = "SELECT * FROM ".DB_PREFIX."active_links WHERE active_links_id = $id;";

            $query = $this->db->query($sql);

            return $query->rows[0];

        }


        public function edit($data, $id) {
             $this->db->query("UPDATE " . DB_PREFIX . "active_links SET icon = '" . $this->db->escape($data['icon']) . "', href = '" . $this->db->escape($data['href']) . "', name = '" . $this->db->escape($data['name']) . "', status = " . (int)$data['status'] . " WHERE active_links_id = " . (int)$id . ";");
        }

        public function delete($id) {
            $this->db->query("DELETE FROM `".DB_PREFIX."active_links` WHERE `active_links_id` = ".(int)$id."");
        }
    }