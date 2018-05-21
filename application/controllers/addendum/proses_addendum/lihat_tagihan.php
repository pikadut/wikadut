<?php 

$data['dir'] = CONTRACT_FOLDER;

$invoice_id = $this->uri->segment(3, 0);

$data['invoice_id'] = $invoice_id;

$post = $this->input->post();

$data['invoice'] = $this->Contract_m->getInvoice($invoice_id)->row_array();
$data['item'] = $this->Contract_m->getInvoiceItem("",$invoice_id)->result_array();

$data['document'] = $this->Contract_m->getInvoiceDoc("",$invoice_id)->result_array();

$view = 'contract/proses_kontrak/view/detail_tagihan_v';

$this->load->view($view,$data);
