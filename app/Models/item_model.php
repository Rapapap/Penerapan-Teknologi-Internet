<?php
namespace App\Models;

use CodeIgniter\Model;

        class Item_model extends Model {
                
                public $db;

                function __construct(){
                        // parent::__construct();
                        $this->db = db_connect();
                }
                
                // Fungsi insert data ke t_model
                function insert_item($data){
                        return $this->db->insert('buku', $data);
                }
                
                // Fungsi menampilkan seluruh data dari t_model         
                function select_all(){
                        $this->db->select('*');
                        $this->db->from('buku');
                        $this->db->order_by('kategori', 'desc');
                        return $this->db->get();
                }

                /**
                 * Fungsi menampilkan data berdasarkan kode model.
                 * Fungsi ini digunakan untuk proses pencarian.
                 */
                function select_by_kode($kd_model){
                        $this->db->select('*');
                        $this->db->from('buku');
                        $this->db->where("(LOWER(id_buku) LIKE '%{$kd_model}%' )");

                        return $this->db->get();
                }

                function select_by_id($kd_model){
                        $this->db->select('*');
                        $this->db->from('buku');
                        $this->db->where('id_buku', $kd_model);

                        return $this->db->get();
                }

                // Fungsi update data ke t_model
                function update_item($kd_model, $data){
                        $this->db->where('id_buku', $kd_model);
                        $this->db->update('buku', $data);
                }

                // Fungsi delete data dari t_model
                function delete_item($kd_model){
                        $this->db->where('id_buku', $kd_model);
                        $this->db->delete('buku');
                }
                

                // fungsi yang digunakan oleh paginationsample
                function select_all_paging($limit=array()){
                        $this->db->select('*');
                        $this->db->from('buku');
                        
                        if ($limit != NULL)
                                $this->db->limit($limit['perpage'], $limit['offset']);
                        
                        return $this->db->get();
                }

                // Menghitung jumlah rows
                function jumlah_item(){
                        $this->db->select('*');
                        $this->db->from('buku');
                        return $this->db->count_all_results();
                }
                
		function eksport_data() {
                        $this->db->select('id_buku, nama_buku, kategori');
                        $this->db->from('buku');
                        return $this->db->get();
                }
        }
?>
