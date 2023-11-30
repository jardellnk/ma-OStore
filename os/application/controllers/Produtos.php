<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produtos extends MY_Controller
{
    /**
     * author: Ramon Silva
     * email: silva018-mg@yahoo.com.br
     *
     */

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('produtos_model');
        $this->data['menuProdutos'] = 'Produtos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar produtos.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('produtos/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->produtos_model->count('produtos');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->produtos_model->get('produtos', '*', '', $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'produtos/produtos';
        return $this->layout();
    }

    public function adicionar()
{
    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aProduto')) {
        $this->session->set_flashdata('error', 'Você não tem permissão para adicionar produtos.');
        redirect(base_url());
    }

    $this->load->library('form_validation');
    $this->data['custom_error'] = '';

    if ($this->form_validation->run('produtos') == false) {
        $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
    } else {
        // Configuração do upload
        $config['upload_path'] = 'assets/produtos/';  // Diretório de destino para salvar a imagem
        $config['allowed_types'] = 'gif|jpg|jpeg|png';  // Tipos de arquivos permitidos
        $config['max_size'] = 2048;  // Tamanho máximo do arquivo em KB (2MB)

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('img')) {
            // Se o upload falhar, exiba mensagens de erro
            $error = array('error' => $this->upload->display_errors());
            $this->data['custom_error'] .= '<div class="form_error"><p>' . $error['error'] . '</p></div>';
        } else {
            // Se o upload for bem-sucedido, continue com o processamento dos dados
            $upload_data = $this->upload->data();

            $precoCompra = $this->input->post('precoCompra');
            $precoCompra = str_replace(",", "", $precoCompra);
            $precoVenda = $this->input->post('precoVenda');
            $precoVenda = str_replace(",", "", $precoVenda);

            $data = [
                'codDeBarra' => set_value('codDeBarra'),
                'descricao' => set_value('descricao'),
                'unidade' => set_value('unidade'),
                'precoCompra' => $precoCompra,
                'precoVenda' => $precoVenda,
                'estoque' => set_value('estoque'),
                'estoqueMinimo' => set_value('estoqueMinimo'),
                'saida' => set_value('saida'),
                'entrada' => set_value('entrada'),
                'img' => 'assets/produtos/' . $upload_data['file_name'],  // Caminho da imagem no servidor
                'especificacao' => set_value('especificacao'),
            ];

            if ($this->produtos_model->add('produtos', $data) == true) {
                $this->session->set_flashdata('success', 'Produto adicionado com sucesso!');
                log_info('Adicionou um produto');
                redirect(site_url('produtos/adicionar/'));
            } else {
                $this->data['custom_error'] .= '<div class="form_error"><p>An Error Occurred.</p></div>';
            }
        }
    }
    $this->data['view'] = 'produtos/adicionarProduto';
    return $this->layout();
}


public function editar()
{
    if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
        $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
        redirect('mapos');
    }

    if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) {
        $this->session->set_flashdata('error', 'Você não tem permissão para editar produtos.');
        redirect(base_url());
    }

    $this->load->library('form_validation');
    $this->data['custom_error'] = '';

    if ($this->form_validation->run('produtos') == false) {
        $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
    } else {
        $precoCompra = $this->input->post('precoCompra');
        $precoCompra = str_replace(",", "", $precoCompra);
        $precoVenda = $this->input->post('precoVenda');
        $precoVenda = str_replace(",", "", $precoVenda);

        // Configuração do upload
        $config['upload_path'] = 'assets/produtos/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        // Verifique se uma nova imagem foi enviada
        if (!empty($_FILES['novaImagem']['name'])) {
            if (!$this->upload->do_upload('novaImagem')) {
                // Se o upload falhar, exiba mensagens de erro
                $error = array('error' => $this->upload->display_errors());
                $this->data['custom_error'] .= '<div class="form_error"><p>' . $error['error'] . '</p></div>';
            } else {
                // Se o upload for bem-sucedido, continue com o processamento dos dados
                $upload_data = $this->upload->data();
                $data['img'] = 'assets/produtos/' . $upload_data['file_name'];

                // Remova a imagem existente, se houver
                if (!empty($this->input->post('removerImagemAtual')) && !empty($this->input->post('imgAtual'))) {
                    unlink($this->input->post('imgAtual'));
                }
            }
        }

        $data['codDeBarra'] = set_value('codDeBarra');
        $data['descricao'] = $this->input->post('descricao');
        $data['unidade'] = $this->input->post('unidade');
        $data['precoCompra'] = $precoCompra;
        $data['precoVenda'] = $precoVenda;
        $data['estoque'] = $this->input->post('estoque');
        $data['estoqueMinimo'] = $this->input->post('estoqueMinimo');
        $data['saida'] = set_value('saida');
        $data['entrada'] = set_value('entrada');
        $data['especificacao'] = $this->input->post('especificacao');

        if ($this->produtos_model->edit('produtos', $data, 'idProdutos', $this->input->post('idProdutos')) == true) {
            $this->session->set_flashdata('success', 'Produto editado com sucesso!');
            log_info('Alterou um produto. ID: ' . $this->input->post('idProdutos'));
            redirect(site_url('produtos/editar/') . $this->input->post('idProdutos'));
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao editar o produto.</p></div>';
        }
    }

    $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));

    $this->data['view'] = 'produtos/editarProduto';
    return $this->layout();
}


    public function visualizar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar produtos.');
            redirect(base_url());
        }

        $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));

        if ($this->data['result'] == null) {
            $this->session->set_flashdata('error', 'Produto não encontrado.');
            redirect(site_url('produtos/editar/') . $this->input->post('idProdutos'));
        }

        $this->data['view'] = 'produtos/visualizarProduto';
        return $this->layout();
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir produtos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir produto.');
            redirect(base_url() . 'index.php/produtos/gerenciar/');
        }

        $this->produtos_model->delete('produtos_os', 'produtos_id', $id);
        $this->produtos_model->delete('itens_de_vendas', 'produtos_id', $id);
        $this->produtos_model->delete('produtos', 'idProdutos', $id);

        log_info('Removeu um produto. ID: ' . $id);

        $this->session->set_flashdata('success', 'Produto excluido com sucesso!');
        redirect(site_url('produtos/gerenciar/'));
    }

    public function atualizar_estoque()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para atualizar estoque de produtos.');
            redirect(base_url());
        }

        $idProduto = $this->input->post('id');
        $novoEstoque = $this->input->post('estoque');
        $estoqueAtual = $this->input->post('estoqueAtual');

        $estoque = $estoqueAtual + $novoEstoque;

        $data = [
            'estoque' => $estoque,
        ];

        if ($this->produtos_model->edit('produtos', $data, 'idProdutos', $idProduto) == true) {
            $this->session->set_flashdata('success', 'Estoque de Produto atualizado com sucesso!');
            log_info('Atualizou estoque de um produto. ID: ' . $idProduto);
            redirect(site_url('produtos/visualizar/') . $idProduto);
        } else {
            $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
        }
    }

    
}
