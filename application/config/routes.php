<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/**
 * MASTER DATA
 */

########################
######### Auth #########
########################

$route['login']         = 'Auth/login';
$route['logout']        = 'Auth/logout';

########################
######### Admin ########
########################

$route['dashboard']                         = 'Admin/dashboard';

/**
 * Akun
 */
$route['admin/akun']              = 'Admin/Master/Akun';
$route['admin/akun/add']          = 'Admin/Master/Akun/create';
$route['admin/akun/edit']         = 'Admin/Master/Akun/update';
$route['admin/akun/delete/(:any)']  = 'Admin/Master/Akun/delete/$1';

/**
 * Supplier
 */
$route['admin/supplier']                    = 'Admin/Master/Supplier';
$route['admin/supplier/add']                = 'Admin/Master/Supplier/createSupplier';
$route['admin/supplier/edit']               = 'Admin/Master/Supplier/editSupplier';
$route['admin/supplier/delete/(:any)']      = 'Admin/Master/Supplier/deleteSupplier/$1';

/**
 * Pelanggan
 */
$route['admin/pelanggan']                   = 'Admin/Master/Pelanggan';
$route['admin/pelanggan/add']               = 'Admin/Master/Pelanggan/createPelanggan';
$route['admin/pelanggan/edit']              = 'Admin/Master/Pelanggan/editPelanggan/$1';
$route['admin/pelanggan/delete/(:any)']     = 'Admin/Master/Pelanggan/deletePelanggan/$1';

/**
 * Karyawan
 */
$route['admin/karyawan']                    = 'Admin/Master/Karyawan/index';
$route['admin/karyawan/add']                = 'Admin/Master/Karyawan/createKaryawan';
$route['admin/karyawan/edit']               = 'Admin/Master/Karyawan/editKaryawan';
$route['admin/karyawan/delete/(:any)']      = 'Admin/Master/Karyawan/deleteKaryawan/$1';

/**
 * Gudang
 */
$route['admin/gudang']                      = 'Admin/Master/Stok';
$route['admin/gudang/show/(:any)']          = 'Admin/Master/Stok/show/$1';
$route['admin/gudang/add']                  = 'Admin/Master/Stok/add';
$route['admin/gudang/edit']                 = 'Admin/Master/Stok/editGudang';
$route['admin/gudang/delete/(:any)']        = 'Admin/Master/Stok/delete/$1';

/**
 * Menu
 */
$route['admin/menu']                  = 'Admin/Master/Menu';
$route['admin/menu/show/(:any)']      = 'Admin/Master/Menu/showMenu/$1';
$route['admin/menu/add']              = 'Admin/Master/Menu/addMenu';
$route['admin/menu/edit']             = 'Admin/Master/Menu/editMenu';
$route['admin/menu/delete/(:any)']    = 'Admin/Master/Menu/deleteMenu/$1';

/**
 * Level Pedas
 */
$route['admin/level/pedas']                 = 'Admin/Master/LevelPedas';
$route['admin/level/pedas/add']             = 'Admin/Master/LevelPedas/addLevelPedas';
$route['admin/level/pedas/edit']            = 'Admin/Master/LevelPedas/editLevelPedas';
$route['admin/level/pedas/delete/(:any)']   = 'Admin/Master/LevelPedas/deleteLevelPedas/$1';

/**
 * Level Pedas
 */
$route['admin/kuah']                 = 'Admin/Master/Kuah';
$route['admin/kuah/add']             = 'Admin/Master/Kuah/addKuah';
$route['admin/kuah/edit']            = 'Admin/Master/Kuah/editKuah';
$route['admin/kuah/delete/(:any)']   = 'Admin/Master/Kuah/deleteKuah/$1';

/**
 * Meja
 */
$route['admin/tables']                      = 'Admin/Master/Meja';
$route['admin/tables/add']                  = 'Admin/Master/Meja/createMeja';
$route['admin/tables/edit']                 = 'Admin/Master/Meja/editMeja';
$route['admin/tables/delete/(:any)']        = 'Admin/Master/Meja/hapusMeja/$1';

#########################
####### Karyawan ########
#########################

$route['dashboard/karyawan']    = 'Karyawan/dashboard';

/**
 * TRANSAKSI
 */

#########################
####### Pembelian #######
#########################

$route['transaksi/pembelian']               = 'Transaksi/Persediaan';
$route['transaksi/pembelian/add']           = 'Transaksi/Persediaan/add';
$route['transaksi/pembelian/update']        = 'Transaksi/Persediaan/update';
$route['transaksi/pembelian/delete/(:any)'] = 'Transaksi/Persediaan/delete/$1';

########################
####### Penjualan ######
########################

$route['transaksi/penjualan']               = 'Transaksi/Penjualan';
$route['transaksi/penjualan/add']           = 'Transaksi/Penjualan/addPenjualan';
$route['transaksi/penjualan/update']        = 'Transaksi/Penjualan/updatePenjualan';
$route['transaksi/penjualan/delete/(:any)'] = 'Transaksi/Penjualan/deletePenjualan/$1';
$route['transaksi/penjualan/rincian/(:any)'] = 'Transaksi/Penjualan/showPenjualan/$1';

########################
###### Persediaan ######
########################

$route['transaksi/persediaan']               = 'Admin/Master/Stok/Persediaan';
$route['transaksi/persediaan/(:any)']        = 'Admin/Master/Stok/showPersediaan/$1';

/**
 * AJAX PENJUALAN
 */
$route['admin/penjualan/ajax/(:any)']           = 'Transaksi/Penjualan/ajaxPenjualan/$1';
$route['admin/user-penjualan/ajax/(:any)']      = 'Ajax/ajaxUserPenjualan/$1';
$route['buku-besar/ajax/(:any)/(:any)/(:any)']  = 'Ajax/ajaxRangeDateWithId/$1/$2/$3';
$route['laporan/ajax/(:any)/(:any)/(:any)']     = 'Ajax/laporan/$1/$2/$3';
$route['laporan/ajax/persediaan']               = 'Ajax/persediaan';

#########################
######## Laporan ########
#########################

$route['laporan/jurnal']                            = 'Buku/Jurnal';

/**
 * BUKU BESAR
 */

$route['laporan/buku-besar']                        = 'Buku/BukuBesar/Index';
$route['laporan/buku-besar/kas']                    = 'Buku/BukuBesar/Kas';
$route['laporan/buku-besar/persediaan']             = 'Buku/BukuBesar/Persediaan';
$route['laporan/buku-besar/penjualan']              = 'Buku/BukuBesar/Penjualan';
$route['laporan/buku-besar/harga-pokok-penjualan']  = 'Buku/BukuBesar/PokokPenjualan';

/**
 * LAPORAN PENJUALAN
 */

 $route['laporan/pembelian']  = 'Buku/Laporan/Pembelian';
 $route['laporan/penjualan']  = 'Buku/Laporan/Penjualan';
 $route['laporan/persediaan']  = 'Buku/Laporan/Persediaan';
