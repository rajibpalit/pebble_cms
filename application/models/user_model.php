



<?php

class User_Model extends CI_Model {

    function get_data($table, $where = FALSE, $table2 = FALSE, $table2_col = FALSE, $table1_col = FALSE, $table3 = FALSE, $table3_col = FALSE, $table2_3_col = FALSE, $limit = FALSE, $start = FALSE, $order_field = FALSE, $order = FALSE) {
        if ($table2 != FALSE) {
            $this->db->join($table2, $table2 . '.' . $table2_col . '=' . $table . '.' . $table1_col);
        }
        if ($table3 != FALSE) {
            $this->db->join($table3, $table3 . '.' . $table3_col . '=' . $table . '.' . $table2_3_col);
        }
        if ($where != FALSE) {
            $this->db->where($where);
        }

        if ($limit != FALSE) {
            $this->db->limit($limit, $start);
        }
        if ($order_field != FALSE && $order) {
            $this->db->order_by($order_field, $order);
        }
        $result = $this->db->get($table)->result_array();

//  print_r($this->db->last_query());
        return $result;
    }

    function insert_data($table, $data) {
        $this->db->insert($table, $data);
//        print_r($this->db->last_query());
        return $this->db->insert_id();
    }

    function update_data($table, $data = false, $where = false) {
        $this->db->update($table, $data, $where);
//        print_r($this->db->last_query());
    }

    function get_bird($q) {
        $this->db->select('email');
        $this->db->like('email', $q);
        $query = $this->db->get('conf_contact');
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = htmlentities(stripslashes($row['email'])); //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    function get_autocom_info1($q, $col_name, $table, $where = FALSE) {
        $this->db->select('*');
        $this->db->like($col_name, $q);
        if ($where != FALSE) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set['label'] = htmlentities(stripslashes($row[$col_name])); //build an array
                $row_set1['value'] = htmlentities(stripslashes($row['client_id'])); //build an array
                $row_set1['value1'] = htmlentities(stripslashes($row['currency'])); //build an array
            }
            echo json_encode($row_set); //format the array into json data
//            echo '<pre>';
//            echo print_r($row_set1);
//            echo '</pre>';
//            exit();
            return $row_set1;
        }
    }

    function get_autocom_info($q, $col_name, $table, $where = FALSE) {
        $this->db->select($col_name);
        $this->db->like($col_name, $q);
        if ($where != FALSE) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = htmlentities(stripslashes($row[$col_name])); //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function all_autocom($tram, $table, $label, $value) {

        $this->db->select('*');
        $this->db->like($label, $tram);
        $query = $this->db->get($table);
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array(
                    'label' => htmlentities(stripslashes($row[$label])),
                    'id' => htmlentities(stripslashes($row[$value]))
                );
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function all_autocom1($tram, $table, $label, $value) {

        $this->db->select('*');
        $this->db->like($label, $tram);
        $this->db->from('conf_product');
        $this->db->join('stock', 'conf_product.id = stock.product_id', 'left');
        $this->db->where(' stock.product_id is null');
        $query = $this->db->get();
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array(
                    'label' => htmlentities(stripslashes($row[$label])),
                    'id' => htmlentities(stripslashes($row[$value]))
                );
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function all_autocom2($tram, $table, $label, $value) {

        $this->db->select('*');
        $this->db->like($label, $tram);
        $this->db->from('conf_rawmaterial');
        $this->db->join('stockrm', 'conf_rawmaterial.id = stockrm.rawmaterial_id', 'left');
        $this->db->where('stockrm.rawmaterial_id is null');
        $query = $this->db->get();
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array(
                    'label' => htmlentities(stripslashes($row[$label])),
                    'id' => htmlentities(stripslashes($row[$value]))
                );
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function all_autocom_con($tram, $table, $label, $value, $con = false, $table2 = FALSE, $table2_col = false, $table1_col = false) {
        $this->db->select('*');
        if ($table2 != FALSE) {
            $this->db->join($table2, $table2 . '.' . $table2_col . '=' . $table . '.' . $table1_col);
        }
        $this->db->like($label, $tram);
        if ($con != false) {
            $this->db->where($con);
        }
        $query = $this->db->get($table);
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array(
                    'label' => htmlentities(stripslashes($row[$label])),
                    'id' => htmlentities(stripslashes($row[$value]))
                );
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function dis_prod_name($tram, $table, $label, $value, $con = false) {
        $this->db->select('*');
        $this->db->like($label, $tram);
        $this->db->where('invoice_id='.$con);
        $query = $this->db->get($table);
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array(
                    'label' => htmlentities(stripslashes($row[$label])),
                    'id' => htmlentities(stripslashes($row[$value]))
                );
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function bank_autocom($tram, $table, $label, $value) {
        $this->db->select('*');
        $this->db->like($label, $tram);
        $query = $this->db->get($table);
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array(
                    'label' => htmlentities(stripslashes($row[$label])),
                    'id' => htmlentities(stripslashes($row[$value]))
                );
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function last_id($col_name, $table) {
        $this->db->select_max($col_name);
        $query = $this->db->get($table);
        $row = $query->row_array();
        return $row[$col_name];
    }

    public function test_auto($q) {
        $label = 'inv_number';
        $value = 'inv_id';
        $query = $this->db->query("select i.inv_id,i.inv_number from packingnote as p join invoice as i on p.inv_id=i.inv_id join shipment as s where s.invoice_id!=p.inv_id and i.inv_number like '%$q%' group by(i.inv_id)");
        if ($query->num_rows >= 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = array(
                    'label' => htmlentities(stripslashes($row[$label])),
                    'id' => htmlentities(stripslashes($row[$value]))
                );
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

}
