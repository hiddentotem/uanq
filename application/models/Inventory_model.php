<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class Inventory_model extends CI_Model
{
    // ------------------------------- INVENTORY ---------------------------------
    public function getInventoryByCabang($cabid, $limit, $start, $keyword)
    {
        $sql = "SELECT inv.*, cb.namaCabang, prc.hargaBeli, prc.hargaJual, prc.hargaReseller FROM inventory inv 
        JOIN cabang cb ON inv.cabangID = cb.idCabang
        JOIN list_harga prc ON inv.hargaID = prc.hargaID
        WHERE inv.cabangID = '{$cabid}'";
        
        if ($keyword) {
            $sql .= " AND inv.produkNama LIKE '%$keyword%'";
        }
        $sql .= " ORDER BY inv.produkID DESC LIMIT {$limit}";
        if ($start) {
            $sql .= ", {$start}";
        }

        return $this->db->query($sql)->result_array();
    }

    public function getAllInventory($email, $limit, $start, $keyword)
    {
        $sql = "SELECT inv.*, cb.namaCabang, prc.hargaBeli, prc.hargaJual, prc.hargaReseller FROM inventory inv 
        JOIN cabang cb ON inv.cabangID = cb.idCabang 
        JOIN list_harga prc ON inv.hargaID = prc.hargaID
        WHERE inv.email = '{$email}'";
        
        if ($keyword) {
            $sql .= " AND inv.produkNama LIKE '%$keyword%'";
        }

        $sql .= " ORDER BY inv.produkID DESC LIMIT {$limit}";
        
        if ($start) {
            $sql .= ", {$start}";
        }

        return $this->db->query($sql)->result_array();
    }

    public function getBarangById($id)
    {
        $sql = "SELECT * FROM inventory i JOIN list_harga h USING (hargaID) WHERE i.produkID = {$id}";
        return $this->db->query($sql)->row_array();
    }

    public function addBarang($data)
    {
        $this->db->insert('inventory', $data);
    }

    public function updateBarang($data, $id)
    {
        $this->db->where('produkID', $id);
        $this->db->update('inventory', $data);
    }

    public function deleteBarang($id)
    {
        $this->db->delete('inventory', ['produkID' => $id]);
    }

    public function getListHarga($email)
    {
        return $this->db->get_where('list_harga', ['email' => $email])->result_array();
    }

    public function getHargaById($id)
    {
        return $this->db->get_where('list_harga', ['hargaID' => $id])->row_array();
    }

    public function addHarga($data)
    {
        $this->db->insert('list_harga', $data);
    }

    public function updateHarga($data, $id)
    {
        $this->db->where('hargaID', $id);
        $this->db->update('list_harga', $data);
    }

    public function deleteHarga($id)
    {
        $this->db->delete('list_harga', ['hargaID' => $id]);
    }

    // ------------------------------ PRODUCTS -----------------------------------
    public function getAllProduk($email, $limit, $start, $keyword)
    {
        $sql = "SELECT pr.*, cb.namaCabang FROM products pr JOIN cabang cb USING (idCabang) WHERE pr.email = '{$email}'";
        if ($keyword) {
            $sql .= " AND pr.namaProduk LIKE '%$keyword%'";
        }
        $sql .= " ORDER BY pr.idProduk DESC LIMIT {$limit}";
        if ($start) {
            $sql .= ", {$start}";
        }

        return $this->db->query($sql)->result_array();
    }

    public function getProdukByCabang($cabid, $limit, $start, $keyword)
    {
        $sql = "SELECT pr.*, cb.namaCabang FROM products pr JOIN cabang cb USING (idCabang) WHERE pr.idCabang = '{$cabid}'";
        if ($keyword) {
            $sql .= " AND pr.namaProduk LIKE '%$keyword%'";
        }
        $sql .= " ORDER BY pr.idProduk DESC LIMIT {$limit}";
        if ($start) {
            $sql .= ", {$start}";
        }

        return $this->db->query($sql)->result_array();
    }

    public function getCabang($email)
    {
        return $this->db->get_where('cabang', ['email' => $email])->result_array();
    }

    public function getProdukById($id)
    {
        return $this->db->get_where('products', ['idProduk' => $id])->row_array();
    }

    public function addProduk($data)
    {
        $this->db->insert('products', $data);
    }

    public function updateProduk($data)
    {
        $id = $this->input->post('idProduk');

        $this->db->where('idProduk', $id);
        $this->db->update('products', $data);
    }

    public function deleteProduk($id)
    {
        $this->db->delete('products', ['idProduk' => $id]);
    }

    // ------------------------------ ORDERS -----------------------------------
    public function getAllOrders($email)
    {
        return $this->db->get_where('orders', ['email' => $email, 'status' => 0])->result_array();
    }

    public function getOrderByIdBarang($id)
    {
        $order = $this->db->get_where('orders', ['idOrder' => $id])->row_array();
        
        $sql = "SELECT * FROM inventory JOIN list_harga USING (hargaID) WHERE produkID = {$order['produkID']}";
        $harga = $this->db->query($sql)->row_array();

        $data['order'] = $order;
        $data['harga'] = $harga;

        return $data;
    }

    public function getOrderByIdProduk($id)
    {
        return $this->db->get_where('orders', ['produkID' => $id, 'status' => 0])->row_array();
    }

    public function countOrders($email)
    {
        return $this->db->get_where('orders', ['email' => $email, 'status' => 0])->num_rows();
    }

    public function totalOrders($email)
    {
        $this->db->select_sum('totalHarga');
        $this->db->where('status', 0);
        $this->db->where('email', $email);
        $result = $this->db->get('orders')->row();

        return $result->totalHarga;
    }

    public function addOrder($data)
    {
        $this->db->insert('orders', $data);
    }

    public function setProses()
    {
        $this->db->set('status', 1);
        $this->db->where('status', 0);
        $this->db->update('orders');
    }

    public function editOrder($data, $id)
    {
        $this->db->where('idOrder', $id);
        $this->db->update('orders', $data);
    }

    public function deleteAllOrder()
    {
        $this->db->delete('orders', ['status' => 0]);
    }

    public function deleteOrderById($id)
    {
        $this->db->delete('orders', ['idOrder' => $id]);
    }

    // ------------------------------ DEALS -----------------------------------
    public function getAllDeals($email)
    {
        $date = date('Y-m-d');
        return $this->db->get_where('orders', ['email' => $email, 'status !=' => 0, 'date(dateCreated)' => $date])->result_array();
    }

    public function countDeals($email)
    {
        $date = date('Y-m-d');
        return $this->db->get_where('orders', ['email' => $email, 'status' => 1, 'dateCreated' => $date])->num_rows();
    }

    public function totalDeals($email)
    {
        $date = date('Y-m-d');

        $this->db->select_sum('totalHarga');
        $this->db->where('status', 1);
        $this->db->where('email', $email);
        $this->db->where('dateCreated', $date);
        $result = $this->db->get('orders')->row();

        return $result->totalHarga;
    }

    public function totalProfit($email)
    {
        $date = date('Y-m-d');

        $this->db->select_sum('profitOrder');
        $this->db->where('status !=', 0);
        $this->db->where('email', $email);
        $this->db->where('dateCreated', $date);
        $result = $this->db->get('orders')->row();

        return $result->profitOrder;
    }

    public function getDealsByDate($email, $startdate, $enddate)
    {
        $this->db->where('status !=', 0);
        $this->db->where('email', $email);
        $this->db->where("date(dateCreated) BETWEEN '$startdate' AND '$enddate'");
        $this->db->order_by('idOrder', 'DESC');
        return $this->db->get('orders')->result_array();
    }

    public function countDealsByDate($email, $startdate, $enddate)
    {
        $this->db->where('status', 1);
        $this->db->where('email', $email);
        $this->db->where("date(dateCreated) BETWEEN '$startdate' AND '$enddate'");
        return $this->db->get('orders')->num_rows();
    }

    public function totalDealsByDate($email, $startdate, $enddate)
    {
        $this->db->select_sum('totalHarga');
        $this->db->where('status', 1);
        $this->db->where('email', $email);
        $this->db->where("dateCreated BETWEEN '$startdate' AND '$enddate'");
        $result = $this->db->get('orders')->row();

        return $result->totalHarga;
    }

    public function totalProfitByDate($email, $startdate, $enddate)
    {
        $this->db->select_sum('profitOrder');
        $this->db->where('status !=', 0);
        $this->db->where('email', $email);
        $this->db->where("date(dateCreated) BETWEEN '$startdate' AND '$enddate'");
        $result = $this->db->get('orders')->row();

        return $result->profitOrder;
    }

    // ------------------------------ CABANG -----------------------------------
    public function getAllCabang($email, $limit, $start, $keyword)
    {
        if ($keyword) {
            $this->db->like('namaCabang', $keyword);
            $this->db->or_like('alamatCabang', $keyword);
            $this->db->or_like('telpCabang', $keyword);
        }

        return $this->db->get_where('cabang', ['email' => $email], $limit, $start)->result_array();
    }

    public function getCabangById($id)
    {
        return $this->db->get_where('cabang', ['idCabang' => $id])->row_array();
    }

    public function addCabang($data)
    {
        $this->db->insert('cabang', $data);
    }

    public function editCabang($data, $id)
    {
        $this->db->where('idCabang', $id);
        $this->db->update('cabang', $data);
    }

    public function deleteCabang($id)
    {
        $this->db->delete('cabang', ['idCabang' => $id]);
    }
}