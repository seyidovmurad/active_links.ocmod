<?php 
    class ControllerExtensionModuleActiveLinks extends Controller {
        private $error = array();

        public function index() {
            $this->load->language('extension/module/active_links');
            $this->document->setTitle($this->language->get('heading_title'));
            
            $this->load->model('setting/setting');
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                
                $this->model_setting_setting->editSetting('module_active_links', $this->request->post);
    
                $this->session->data['success'] = $this->language->get('text_success');
    
                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }

            $data['heading_title'] = $this->language->get('heading_title');
		
            $data['text_edit'] = $this->language->get('text_edit');
            $data['text_enabled'] = $this->language->get('text_enabled');
            $data['text_disabled'] = $this->language->get('text_disabled');
            
            $data['entry_status'] = $this->language->get('entry_status');

            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');

            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } else {
                $data['error_warning'] = '';
            }

            $data['breadcrumbs'] = array();
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/active_links', 'user_token=' . $this->session->data['user_token'], true)
            );
            
            $data['action'] = $this->url->link('extension/module/active_links', 'user_token=' . $this->session->data['user_token'], true);

		    $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
            
            if (isset($this->request->post['module_active_links_status'])) {
                $data['module_active_links_status'] = $this->request->post['module_active_links_status'];
            } else {
                $data['module_active_links_status'] = $this->config->get('module_active_links_status');
            }
    
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
    
    
            $this->response->setOutput($this->load->view('extension/module/active_links', $data));
            
        }

        public function table() {
            $data = array();

            //buttons
            $data['add'] = $this->url->link('extension/module/active_links/list', 'user_token=' . $this->session->data['user_token'], true);
            $data['delete'] = $this->url->link('extension/module/active_links/delete', 'user_token=' . $this->session->data['user_token'], true);
            

           $list = $this->loadLinks();
        
           if($list) {
            $data['links'] = $list; 
           }
            
           
            //errors
            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } else {
                $data['error_warning'] = '';
            }

            //load datas
            $this->load->language('extension/module/active_links');
            $this->document->setTitle($this->language->get('heading_title'));

            //set language
            $data['heading_title'] = $this->language->get('heading_title');
            //add to language
            $data['button_add'] = 'Add New Link';
            $data['button_delete'] = 'Delete Link';
            $data['text_confirm'] = 'Do you want to delete links?';
            $data['text_table'] = 'Active Links Table';
            $data['text_name'] = 'Name';
            $data['text_icon'] = 'Icon';
            $data['text_href'] = 'Link';
            $data['text_status'] = 'Status';
            $data['text_action'] = 'Action';
            $data['text_no_result'] = 'There is nothing to show';

           

            //breadcrumbs
            $data['breadcrumbs'] = array();
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/active_links/list', 'user_token=' . $this->session->data['user_token'], true)
            );

            //set header
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
    
    
            $this->response->setOutput($this->load->view('extension/module/active_links_table', $data));
        }

        public function list() {

            $data = array();

            $data['action'] = $this->url->link('extension/module/active_links/list', 'user_token=' . $this->session->data['user_token'], true);


            if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

                $this->load->model('extension/module/active_links');
                $this->request->post['html_id'] = md5(uniqid(rand(), true));
                $this->model_extension_module_active_links->add($this->request->post);
                $this->table();
                return;
            }

            //errors
            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } else {
                $data['error_warning'] = '';
            }

            //load datas
            $this->load->language('extension/module/active_links');
            $this->document->setTitle($this->language->get('heading_title'));

            //set language
            $data['heading_title'] = $this->language->get('heading_title');
            $data['text_add'] = 'Add'; //add this to language
            $data['entry_routes'] = 'Routes'; //add this too
            $data['entry_icon'] = 'Icon\'s name';
            $data['entry_name'] = "Column's Name";
            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');

            //breadcrumbs
            $data['breadcrumbs'] = array();
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/active_links/list', 'user_token=' . $this->session->data['user_token'], true)
            );

            //set header
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
    
    
            $this->response->setOutput($this->load->view('extension/module/active_links_list', $data));
        }


        public function edit() {

            $data = array();

            $data['action'] = $this->url->link('extension/module/active_links/edit', 'user_token=' . $this->session->data['user_token'], true);


            if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

                $this->load->model('extension/module/active_links');
               
                $post = $this->request->post;
                
                if(isset($post['active_links_id'])) {
                    $this->model_extension_module_active_links->edit($post, $post['active_links_id']);
                    $this->table(false);
                    return;
                }
            }

            if (($this->request->server['REQUEST_METHOD'] == 'GET') && $this->validate()) {

                if(isset($this->request->get['id'])) {
                    $id = $this->request->get['id'];
                    $this->load->model('extension/module/active_links');
                    
                    $model = $this->model_extension_module_active_links->getById($id);
                    
                    $data['link'] = array(
                        'name' => $model['name'],
                        'href' => $model['href'],
                        'active_links_id' => $model['active_links_id'],
                        'icon' => $model['icon'],
                        'status' => $model['status']
                    );
                    
                }
                else {
                    print('Id doesn\'t exist in url');
                    return;
                }
            }

            //errors
            if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
            } else {
                $data['error_warning'] = '';
            }

            //load datas
            $this->load->language('extension/module/active_links');
            $this->document->setTitle($this->language->get('heading_title'));

            //set language
            $data['heading_title'] = $this->language->get('heading_title');
            $data['text_add'] = 'Edit'; //add this to language
            $data['entry_routes'] = 'Routes'; //add this too
            $data['entry_icon'] = 'Icon\'s name';
            $data['entry_name'] = "Column's Name";
            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');

            //breadcrumbs
            $data['breadcrumbs'] = array();
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
            );
    
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/active_links/edit', 'user_token=' . $this->session->data['user_token'], true)
            );

            //set header
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
    
    
            $this->response->setOutput($this->load->view('extension/module/active_links_list', $data));
        }

        public function delete() {

            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            
                $ids = $this->request->post['selected'];
                $this->load->model('extension/module/active_links');
                foreach($ids as $id) {
                    $this->model_extension_module_active_links->delete($id);
                }
            }

            $this->table(false);
            
        }

        public function validate() {
            if (!$this->user->hasPermission('modify', 'extension/module/active_links')) {
                $this->error['warning'] = $this->language->get('error_permission');
            }
    
            return !$this->error;
        }

        private function loadLinks() {
            $this->load->model('extension/module/active_links');
           
            foreach($this->model_extension_module_active_links->getList() as $list) {
               $links[] = array(
                'active_links_id' => $list['active_links_id'],
                'name' => $list['name'],
                'icon' => $list['icon'],
                'href' => $list['href'],
                'status' => $list['status'],
                'edit' => $this->url->link('extension/module/active_links/edit', 'id='.$list['active_links_id']. '&user_token=' . $this->session->data['user_token'], true)
               );
            }

            return isset($links) ? $links : null;
        }

        public function install() {
            $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "active_links`");

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
            
            $this->load->model('user/user_group');

            $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'extension/active_links');
            $this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'extension/active_links');
        }

        public function uninstall() {
            $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "active_links`");
        }
    }