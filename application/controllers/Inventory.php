<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller user yang mengelola user page
class Inventory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Memanggil helper checkLogin
        checkLogin();

        $this->load->model('Inventory_model', 'invent');
    }

    // ------------------------------ PRODUCTS ----------------------------------- //
    public function products()
    {
        $email = $this->session->userdata('email');

        $this->load->library('pagination');

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');

            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('inventory');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        $this->db->like('produkNama', $data['keyword']);
        $this->db->from('inventory');
        $this->db->where('email', $email);

        $config['total_rows'] = $this->db->count_all_results();
        $config['base_url'] = 'http://localhost:8080/uanq/inventory/products';
        $config['num_links'] = 3;
        $config['per_page'] = 8;

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);

        if ($this->input->get('id')) {
            $cabid = $this->input->get('id');
            $data['produk'] = $this->invent->getInventoryByCabang($cabid, $config['per_page'], $data['start'], $data['keyword']);
        } else {
            $data['produk'] = $this->invent->getAllInventory($email, $config['per_page'], $data['start'], $data['keyword']);
        }

        $data['cabang'] = $this->invent->getCabang($email);
        $data['listharga'] = $this->invent->getListHarga($email);
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['title'] = 'Products';

        $this->pagination->initialize($config);

        $this->form_validation->set_rules('produkNama', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required|trim');
        $this->form_validation->set_rules('list-harga', 'List Harga', 'required|trim');
        $this->form_validation->set_rules('hargaJual', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('hargaBeli', 'Harga Beli', 'required|trim');
        $this->form_validation->set_rules('hargaReseller', 'Harga Reseller', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/products', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->session->userdata('email');
            $produkNama = htmlspecialchars($this->input->post('produkNama', true));
            $cabang = htmlspecialchars($this->input->post('cabang', true));
            $listHarga = htmlspecialchars($this->input->post('list-harga', true));
            $hargaBeli = htmlspecialchars($this->input->post('hargaBeli', true));
            $hargaJual = htmlspecialchars($this->input->post('hargaJual', true));
            $hargaReseller = htmlspecialchars($this->input->post('hargaReseller', true));
            $date = date('Y-m-d H:i:s');

            $data = [
                'hargaID' => $listHarga,
                'cabangID' => $cabang,
                'email' => $email,
                'produkNama' => $produkNama,
                'produkTerjual' => NULL,
                'produkProcess' => NULL,
                'dateCreated' => $date,
                'dateModified' => $date,
                'emailCreated' => $email,
                'emailModified' => $email,
                'produkStatus' => 1
            ];

            $this->invent->addBarang($data);
            $this->session->set_flashdata('succadd', 'barang');
            redirect('inventory/products');
        }
    }

    public function priceList()
    {
        $email = $this->session->userdata('email');

        $this->load->library('pagination');

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');

            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('inventory/pricelist');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        $this->db->like('hargaTipe', $data['keyword']);
        $this->db->from('list_harga');
        $this->db->where('email', $email);

        $config['total_rows'] = $this->db->count_all_results();
        $config['base_url'] = 'http://localhost:8080/uanq/inventory/pricelist';
        $config['num_links'] = 3;
        $config['per_page'] = 8;

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['harga'] = $this->invent->getListHarga($email);
        $data['listharga'] = $this->invent->getListHarga($email);
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['title'] = 'Price List';

        $this->pagination->initialize($config);

        $this->form_validation->set_rules('hargaTipe', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('hargaBeli', 'Harga Beli', 'required|trim');
        $this->form_validation->set_rules('hargaJual', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('hargaReseller', 'Harga Reseller', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/pricelist', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->session->userdata('email');
            $hargaTipe = $this->input->post('hargaTipe');
            $beli = $this->input->post('hargaBeli');
            $jual = $this->input->post('hargaJual');
            $reseller = $this->input->post('hargaReseller');
            $date = date('Y-m-d H:i:s');

            $data = [
                'email' => $email,
                'hargaTipe' => $hargaTipe,
                'hargaBeli' => $beli,
                'hargaJual' => $jual,
                'hargaReseller' => $reseller,
                'dateCreated' => $date,
                'dateModified' => $date,
                'emailCreated' => $email,
                'emailModified' => $email,
                'hargaStatus' => 1,
            ];

            $this->invent->addHarga($data);
            $this->session->set_flashdata('succadd', 'harga');
            redirect('inventory/pricelist');
        }
    }

    public function ajaxGetBarang()
    {
        echo json_encode($this->invent->getBarangById($_POST['idJson']));
    }

    public function ajaxGetHarga()
    {
        echo json_encode($this->invent->getHargaById($_POST['idJson']));
    }

    public function editBarang()
    {
        $this->form_validation->set_rules('produkNama', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required|trim');
        $this->form_validation->set_rules('list-harga', 'List Harga', 'required|trim');
        $this->form_validation->set_rules('hargaJual', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('hargaBeli', 'Harga Beli', 'required|trim');
        $this->form_validation->set_rules('hargaReseller', 'Harga Reseller', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            redirect('inventory/products');
        } else {
            $email = $this->session->userdata('email');
            $id = $this->input->post('produkID');
            $produkNama = htmlspecialchars($this->input->post('produkNama', true));
            $cabang = htmlspecialchars($this->input->post('cabang', true));
            $listHarga = htmlspecialchars($this->input->post('list-harga', true));
            $beli = htmlspecialchars($this->input->post('hargaBeli', true));
            $jual = htmlspecialchars($this->input->post('hargaJual', true));
            $reseller = htmlspecialchars($this->input->post('hargaReseller', true));
            $date = date('Y-m-d H:i:s');

            $data = [
                'hargaID' => $listHarga,
                'cabangID' => $cabang,
                'produkNama' => $produkNama,
                'dateModified' => $date,
                'emailModified' => $email
            ];

            $this->invent->updateBarang($data, $id);

            $this->session->set_flashdata('succedit', 'barang');
            redirect('inventory/products');
        }
    }

    public function editHarga()
    {
        $this->form_validation->set_rules('hargaTipe', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('hargaBeli', 'Harga Beli', 'required|trim');
        $this->form_validation->set_rules('hargaJual', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('hargaReseller', 'Harga Reseller', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            redirect('inventory/pricelist');
        } else {
            $email = $this->session->userdata('email');
            $id = $this->input->post('hargaID');
            $hargaTipe = htmlspecialchars($this->input->post('hargaTipe', true));
            $beli = htmlspecialchars($this->input->post('hargaBeli', true));
            $jual = htmlspecialchars($this->input->post('hargaJual', true));
            $reseller = htmlspecialchars($this->input->post('hargaReseller', true));
            $date = date('Y-m-d H:i:s');

            $data = [
                'hargaTipe' => $hargaTipe,
                'hargaBeli' => $beli,
                'hargaJual' => $jual,
                'hargaReseller' => $reseller,
                'dateModified' => $date,
                'emailModified' => $email
            ];

            $this->invent->updateHarga($data, $id);

            $this->session->set_flashdata('succedit', 'harga');
            redirect('inventory/pricelist');
        }
    }

    public function deleteBarang($id)
    {
        $this->invent->deleteBarang($id);
        $this->session->set_flashdata('succdelete', 'barang');
        redirect('inventory/products');
    }

    public function deleteHarga($id)
    {
        $this->invent->deleteHarga($id);
        $this->session->set_flashdata('succdelete', 'harga');
        redirect('inventory/pricelist');
    }

    public function orderBarang()
    {
        $email = $this->session->userdata('email');

        $this->form_validation->set_rules('harga', 'Harga', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
        $this->form_validation->set_rules('customerName', 'Customer Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failadd', 'order');
            redirect('inventory/products');
        } else {
            $produkID = htmlspecialchars($this->input->post('produkIDs', true));
            $cabangID = htmlspecialchars($this->input->post('cabangID', true));
            $customerName = htmlspecialchars($this->input->post('customerName', true));
            $produk = htmlspecialchars($this->input->post('produk', true));
            $harga = htmlspecialchars($this->input->post('harga', true));
            $quantity = htmlspecialchars($this->input->post('quantity', true));
            $totalHarga = htmlspecialchars($this->input->post('totalHarga', true));
            $hargaBeli = htmlspecialchars($this->input->post('hargaModal', true));
            $date = Date('Y-m-d H:i:s');
            $profit = $totalHarga - ($hargaBeli * $quantity);

            $barang = $this->invent->getBarangById($produkID);
            $cekProduk = $this->invent->getOrderByIdProduk($produkID);

            if ($cekProduk < 1) {

                $data = [
                    'produkID' => $produkID,
                    'idCabang' => $cabangID,
                    'email' => $email,
                    'namaBarang' => $produk,
                    'customerName' => $customerName,
                    'terjualBarang' => $barang['produkTerjual'],
                    'hargaJual' => $harga,
                    'hargaBeli' => $hargaBeli,
                    'qtyOrder' => $quantity,
                    'totalHarga' => $totalHarga,
                    'profitOrder' => $profit,
                    'Keterangan' => "ORDER " . $date,
                    'status' => 0,
                    'dateCreated' => $date,
                    'dateModified' => $date,
                    'emailCreated' => $email,
                    'emailModified' => $email
                ];

                $this->invent->addOrder($data);

                $this->session->set_flashdata('addorder', $produk);
                redirect('inventory/products');
            } else {
                $this->session->set_flashdata('failorder', $produk);
                redirect('inventory/products');
            }
        }
    }

    // ------------------------------ INVENTORY ----------------------------------- //

    public function index()
    {
        $email = $this->session->userdata('email');

        $this->load->library('pagination');

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');

            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('inventory');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        $this->db->like('namaProduk', $data['keyword']);
        $this->db->from('products');
        $this->db->where('email', $email);

        $config['total_rows'] = $this->db->count_all_results();
        $config['base_url'] = 'http://localhost:8080/uanq/inventory/index';
        $config['num_links'] = 3;
        $config['per_page'] = 8;

        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);

        if ($this->input->get('id')) {
            $cabid = $this->input->get('id');
            $data['produk'] = $this->invent->getProdukByCabang($cabid, $config['per_page'], $data['start'], $data['keyword']);
        } else {
            $data['produk'] = $this->invent->getAllProduk($email, $config['per_page'], $data['start'], $data['keyword']);
        }

        $data['cabang'] = $this->invent->getCabang($email);
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        $data['title'] = 'Inventory';

        $this->pagination->initialize($config);

        $this->form_validation->set_rules('namaProduk', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required|trim');
        $this->form_validation->set_rules('stokProduk', 'Stok Produk', 'required|trim');
        $this->form_validation->set_rules('hargaJual', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('hargaBeli', 'Harga Beli', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/index', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->session->userdata('email');
            $cabang = $this->input->post('cabang');
            $nama = $this->input->post('namaProduk');
            $stok = $this->input->post('stokProduk');
            $beli = $this->input->post('hargaBeli');
            $jual = $this->input->post('hargaJual');
            $profit = $jual - $beli;
            $date = date('Y-m-d');
            $terjual = 0;

            $data = [
                'idCabang' => $cabang,
                'email' => $email,
                'namaProduk' => $nama,
                'stokProduk' => $stok,
                'terjualProduk' => $terjual,
                'hargaBeli' => $beli,
                'hargaJual' => $jual,
                'profitProduk' => $profit,
                'dateCreated' => $date,
                'dateModified' => $date
            ];

            $this->invent->addProduk($data);
            $this->session->set_flashdata('produkadd', 'ditambah');
            redirect('inventory');
        }
    }

    public function ajaxGetProduk()
    {
        echo json_encode($this->invent->getProdukById($_POST['idJson']));
    }

    public function editProduk()
    {

        $this->form_validation->set_rules('namaProduk', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('stokProduk', 'Stok Produk', 'required|trim');
        $this->form_validation->set_rules('hargaJual', 'Harga Jual', 'required|trim');
        $this->form_validation->set_rules('hargaBeli', 'Harga Beli', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            redirect('inventory');
        } else {
            $cabang = htmlspecialchars($this->input->post('cabang', true));
            $nama = htmlspecialchars($this->input->post('namaProduk', true));
            $stok = htmlspecialchars($this->input->post('stokProduk', true));
            $beli = htmlspecialchars($this->input->post('hargaBeli', true));
            $jual = htmlspecialchars($this->input->post('hargaJual', true));
            $profit = $jual - $beli;

            $data = [
                'idCabang' => $cabang,
                'namaProduk' => $nama,
                'stokProduk' => $stok,
                'hargaBeli' => $beli,
                'hargaJual' => $jual,
                'profitProduk' => $profit,
                'dateModified' => date('Y-m-d')
            ];

            $this->invent->updateProduk($data);

            $this->session->set_flashdata('produkupd', 'Add new');
            redirect('inventory');
        }
    }

    public function deleteProduk($id)
    {
        $this->invent->deleteProduk($id);
        $this->session->set_flashdata('produkdel', 'dihapus');
        redirect('inventory');
    }

    // ------------------------------ ORDERS ----------------------------------- //
    public function orders()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['orders'] = $this->invent->getAllOrders($email);
        $data['count'] = $this->invent->countOrders($email);
        $data['total'] = $this->invent->totalOrders($email);
        $data['title'] = 'Orders';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/orders', $data);
        $this->load->view('templates/footer');
    }

    public function ajaxGetOrder()
    {
        echo json_encode($this->invent->getOrderByIdBarang($_POST['idJson']));
    }

    public function addOrders()
    {
        $email = $this->session->userdata('email');

        $this->form_validation->set_rules('qty', 'Quantity Produk', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('failform', 'order');
            redirect('inventory');
        } else {
            $id = $this->input->post('idProduks');
            $nama = $this->input->post('produk');
            $stok = $this->input->post('stoky');
            $qty = $this->input->post('qty');
            $date = $this->input->post('date');

            $produk = $this->invent->getProdukById($id);
            $cekProduk = $this->invent->getOrderByIdProduk($id);

            if ($cekProduk < 1) {
                $totalOrder = $qty * $produk['hargaJual'];
                $profitOrder = $qty * $produk['profitProduk'];

                $data = [
                    'idProduk' => $id,
                    'idCabang' => $produk['idCabang'],
                    'email' => $email,
                    'namaBarang' => $nama,
                    'stokBarang' => $stok - $qty,
                    'terjualBarang' => $produk['terjualProduk'] + $qty,
                    'hargaJual' => $produk['hargaJual'],
                    'hargaBeli' => $produk['hargaBeli'],
                    'qtyOrder' => $qty,
                    'totalHarga' => $totalOrder,
                    'profitOrder' => $profitOrder,
                    'status' => 0,
                    'dateCreated' => $date,
                    'dateModified' => 0
                ];

                $this->invent->addOrder($data);

                $this->session->set_flashdata('addorder', $nama);
                redirect('inventory');
            } else {
                $this->session->set_flashdata('failorder', $nama);
                redirect('inventory');
            }
        }
    }

    public function prosesOrder()
    {
        $email = $this->session->userdata('email');
        $orders = $this->invent->getAllOrders($email);

        foreach ($orders as $order) {
            $id = $order['idProduk'];
            $stok = $order['stokBarang'];
            $terjual = $order['terjualBarang'];

            $data = [
                'email' => $email,
                'transaksi' => $order['namaBarang'],
                'income' => $order['hargaJual'],
                'outcome' => $order['hargaBeli'],
                'dateCreated' => date('Y-m-d'),
                'dateModified' => 0
            ];

            $this->db->set('stokProduk', $stok);
            $this->db->set('terjualProduk', $terjual);
            $this->db->where('idProduk', $id);
            $this->db->update('products');

            $this->db->insert('earnings', $data);
        }

        $this->invent->setProses();

        $this->session->set_flashdata('prosesorder', 'Proses order');
        redirect('inventory/orders');
    }

    public function cancelOrder()
    {
        $this->invent->deleteAllOrder();

        $this->session->set_flashdata('cancelorder', 'dihapus');
        redirect('inventory/orders');
    }

    public function editOrder()
    {
        $this->form_validation->set_rules('customerName', 'Nama Customer', 'required|trim');
        $this->form_validation->set_rules('harga', 'Nama Customer', 'required|trim');
        $this->form_validation->set_rules('quantity', 'Nama Customer', 'required|trim');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('faileditorder', 'Gagal edit');
            redirect('inventory/orders');
        } else {
            $email = $this->session->userdata('email');

            $idOrders = htmlspecialchars($this->input->post('idOrders', true));
            $customerName = htmlspecialchars($this->input->post('customerName', true));
            $namaBarang = htmlspecialchars($this->input->post('namaBarang', true));
            $harga = htmlspecialchars($this->input->post('harga', true));
            $quantity = htmlspecialchars($this->input->post('quantity', true));
            $totalHarga = htmlspecialchars($this->input->post('totalHarga', true));
            $hargaModal = htmlspecialchars($this->input->post('hargaModal', true));
            $profit = $totalHarga - ($hargaModal * $quantity);

            $data = [
                'customerName' => $customerName,
                'hargaJual' => $harga,
                'hargaBeli' => $hargaModal,
                'qtyOrder' => $quantity,
                'totalHarga' => $totalHarga,
                'totalHarga' => $totalHarga,
                'profitOrder' => $profit,
                'dateModified' => date('Y-m-d H:i:s'),
                'emailModified' => $email
            ];

            $this->invent->editOrder($data, $idOrders);

            $this->session->set_flashdata('editorder', 'Berhasil edit');
            redirect('inventory/orders');
        }
    }

    public function deleteOrder($id)
    {
        $this->invent->deleteOrderById($id);

        $this->session->set_flashdata('deleteorder', 'dihapus');
        redirect('inventory/orders');
    }

    // ------------------------------ DEALS -----------------------------------
    public function deals()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['deals'] = $this->invent->getAllDeals($email);
        $data['count'] = $this->invent->countDeals($email);
        $data['total'] = $this->invent->totalDeals($email);
        $data['profit'] = $this->invent->totalProfit($email);
        $data['title'] = 'Deals';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventory/deals', $data);
        $this->load->view('templates/footer');
    }

    public function sortDeals()
    {
        if ($this->input->get('end-date')) {
            $startdate = $this->input->get('start-date');
            $enddate = $this->input->get('end-date');
            $sort = $this->input->get('sort');
            $email = $this->session->userdata('email');

            $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
            $data['deals'] = $this->invent->getDealsByDate($email, $startdate, $enddate);
            $data['count'] = $this->invent->countDealsByDate($email, $startdate, $enddate);
            $data['total'] = $this->invent->totalDealsByDate($email, $startdate, $enddate);
            $data['profit'] = $this->invent->totalProfitByDate($email, $startdate, $enddate);

            $data['date'] = $startdate . ' - ' . $enddate;
            $data['title'] = $sort . ' Deals';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/sort-deals', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('inventory/deals');
        }
    }

    // ------------------------------ CABANG -----------------------------------
    public function cabang()
    {
        $email = $this->session->userdata('email');

        $this->load->library('pagination');

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');

            $this->session->set_userdata('keyword', $data['keyword']);
            redirect('inventory/cabang');
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        $this->db->like('namaCabang', $data['keyword']);
        $this->db->or_like('alamatCabang', $data['keyword']);
        $this->db->or_like('telpCabang', $data['keyword']);
        $this->db->from('cabang');

        $config['total_rows'] = $this->db->count_all_results();
        $config['base_url'] = 'http://localhost:8080/uanq/inventory/cabang';
        $config['num_links'] = 3;
        $config['per_page'] = 5;

        $data['title'] = 'Cabang';
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $this->uri->segment(3);
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['cabang'] = $this->invent->getAllCabang($email, $config['per_page'], $data['start'], $data['keyword']);

        $this->pagination->initialize($config);

        $this->form_validation->set_rules('namaCabang', 'Nama cabang', 'required|trim', ['required' => 'Nama cabang kamu belum di isi!', 'min_length' => 'Password is too short!']);
        $this->form_validation->set_rules('alamatCabang', 'Alamat cabang', 'required|trim', ['required' => 'Alamat cabang kamu belum di isi!']);
        $this->form_validation->set_rules('telpCabang', 'Telephone cabang', 'required|numeric|trim', ['required' => 'Telephone cabang kamu belum di isi!', 'numeric' => 'Kamu hanya boleh memasukan angka saja!']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inventory/cabang', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->session->userdata('email');
            $nama = $this->input->post('namaCabang');
            $alamat = $this->input->post('alamatCabang');
            $telp = $this->input->post('telpCabang');

            $data = [
                'email' => $email,
                'namaCabang' => $nama,
                'alamatCabang' => $alamat,
                'telpCabang' => $telp
            ];

            $this->invent->addCabang($data);
            $this->session->set_flashdata('cabangadd', $nama);
            redirect('inventory/cabang');
        }
    }

    public function ajaxGetCabang()
    {
        echo json_encode($this->invent->getCabangByid($_POST['idJson']));
    }

    public function editCabang()
    {
        $this->form_validation->set_rules('namaCabang', 'Nama cabang', 'required|trim', ['required' => 'Nama cabang kamu belum di isi!', 'min_length' => 'Password is too short!']);
        $this->form_validation->set_rules('alamatCabang', 'Alamat cabang', 'required|trim', ['required' => 'Alamat cabang kamu belum di isi!']);
        $this->form_validation->set_rules('telpCabang', 'Telephone cabang', 'required|numeric|trim', ['required' => 'Telephone cabang kamu belum di isi!', 'numeric' => 'Kamu hanya boleh memasukan angka saja!']);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('faileditcabang', 'gagal edit');
            redirect('inventory/cabang');
        } else {
            $email = $this->session->userdata('email');
            $id = $this->input->post('idCabang');
            $nama = $this->input->post('namaCabang');
            $alamat = $this->input->post('alamatCabang');
            $telp = $this->input->post('telpCabang');

            $data = [
                'email' => $email,
                'namaCabang' => $nama,
                'alamatCabang' => $alamat,
                'telpCabang' => $telp
            ];

            $this->invent->editCabang($data, $id);
            $this->session->set_flashdata('cabangedit', $nama);
            redirect('inventory/cabang');
        }
    }

    public function deleteCabang($id)
    {
        $this->invent->deleteCabang($id);

        $this->session->set_flashdata('cabangdelete', 'dihapus');
        redirect('inventory/cabang');
    }
}