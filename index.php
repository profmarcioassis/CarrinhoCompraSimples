<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de compras</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h2 {
            background-color: darkblue;
            width: 100%;
            padding: 20px;
            text-align: center;
            color: white;
            margin: 10px;
        }

        .carrinho-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            margin: 10px;
        }

        .produto {
            width: 20em;
            padding: 20px 10px;
            text-align: center;
        }

        .produto img {
            width: auto;
            max-width: 300px;
            height: 250px;
        }

        .produto a {
            display: block;
            width: 100%;
            padding: 10px;
            color: white;
            background-color: #5fb382;
            text-align: center;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .itens-carrinho {
            display: block;
            margin: 20px;
            padding: 10px;
        }

        p {
            padding: 10px;
            font-size: 15px;
        }

        .limpar-carrinho {
            width: 100%;
            text-align: right;
            margin-top: 20px;
        }


        .limpar-carrinho a {
            display: flexbox;
            width: 20%;
            padding: 10px;
            color: white;
            background-color: brown;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
        }

        #quantidade-produto {
            width: 45px;
        }
    </style>

</head>

<body>


    <div class="carrinho-container">
        <h2>Produtos</h2>
        <?php

        //No caso de um sistema real, os dados abaixo devem vir do banco de dados
        $items = array(
            ['idProduto' => 1 ,'nomeProduto' => 'Gabinete Gamer', 'imagemProduto' => 'images/item1.jpeg', 'precoProduto' => '200.60'],
            ['idProduto' => 2, 'nomeProduto' => 'Webcam Logitech', 'imagemProduto' => 'images/item2.jpeg', 'precoProduto' => '100'],
            ['idProduto' => 3, 'nomeProduto' => 'Monitor Gamer', 'imagemProduto' => 'images/item3.jpeg', 'precoProduto' => '30000.78']
        );

        //print_r($items);

        foreach ($items as $value) {
        ?>
            <div class=" produto">
                <img src="<?php echo $value['imagemProduto']; ?>" alt="Imagem do produto">
                <br>
                <?php echo $value['nomeProduto']; ?>
                <br>
                <b>
                <?php echo "R$" . number_format($value['precoProduto'], 2, ",", ".") ?></b>
                <br>
                <a href="?idProduto=<?php echo $value['idProduto']-1; ?>">Adicionar ao carrinho</a>
            </div>
            <!--produto-->

        <?php
        }
        unset($value);
        ?>

    </div>
    <!--carrinho-container-->


    <?php
    if (isset($_GET['idProduto'])) {
        //vamos adicionar os items ao carrinho
        $idProduto = (int) $_GET['idProduto'];
        //print_r($items[1]['idProduto']);
        
        if (isset($items[$idProduto])) {
            if (isset($_SESSION['carrinho'][$idProduto])) {
                $_SESSION['carrinho'][$idProduto]['quantidadeProduto']++;
            } else {//quando o item ainda n eestá no carrinho
                $_SESSION['carrinho'][$idProduto] = array(
                    'idProduto' => $items[$idProduto]['idProduto'],
                    'nomeProduto' => $items[$idProduto]['nomeProduto'],
                    'quantidadeProduto' => 1,
                    'precoProduto' => $items[$idProduto]['precoProduto']
                );
            }
        } else {
            die("Você não pode adicionar um item que não existe");
        }

        print_r($_SESSION['carrinho'][$idProduto]);

    ?>

        <div class="itens-carrinho">
            <h2 class="title">Carrinho</h2>

            <div class="limpar-carrinho">
                <a href="limparCarrinho.php">Limpar carrinho</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>Código do Produto</th>    
                    <th>Nome do Produto</th>
                        <th>Quantidade do produto</th>
                        <th>Preço do produto</th>
                        <th>Subtotal</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrinho'] as $value) {
                    ?>
                        <tr>
                        <td><?php echo $value['idProduto'] ?></td>
                            <td><?php echo $value['nomeProduto'] ?></td>
                            <td>
                                <!--Link dos ícones: https://icons.getbootstrap.com/-->
                                <a href="" onclick="addItem(<?php echo $value['idProduto'] ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" /></svg></a>
                                <input type="text" 
                                readonly 
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                id="quantidade-produto" value="<?php echo $value['quantidadeProduto'] ?>" />
                                
                                <a href="#" id="quantidade-produto" onclick="addItem(<?php echo $value['idProduto'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" /></svg></a>
                            </td>
                            <td><?php echo "R$" . number_format($value['precoProduto'], 2, ",", ".") ?></td>
                            <td><?php echo "R$" . number_format($value['quantidadeProduto'] * $value['precoProduto'], 2, ",", ".") ?></td>
                            <td>
                                <a class="remover-item" href="excluirItem.php?idProduto=<?php echo $value['idProduto']-1 ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg></a>
                            </td>
                        </tr>
                    <?php
                        $total += $value['quantidadeProduto'] * $value['precoProduto'];
                    }
                    ?>

                    <tr>
                        <th colspan="4" style="text-align: right;">Total</th>
                        <th><?php echo "R$" . number_format($total, 2, ",", ".") ?></th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        <?php
    }
        ?>

        </div>
        <!--itens-carrinho-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <script>
            let value = $('#quantidade-produto').val();

            $('#quantidade-produto').on('change', function() {
                if ($(this).val() > value) {
                    console.log('Input was incremented');
                } else {
                    console.log('Input was decremented');
                }
                value = $(this).val();
            });


            function addItem(idProduto) {
                let quantidade = parseInt(document.getElementById('quantidade-produto').value);
                if(quantidade > 0){
                    document.getElementById('quantidade-produto').value = quantidade + 1;                
                }else{
                    document.getElementById('quantidade-produto').value = 1;
                }
            }

            function removeItem(idProduto) {
                let quantidade = parseInt(document.getElementById('quantidade-produto').value);
                if(quantidade > 0){
                    document.getElementById('quantidade-produto').value = quantidade - 1;                
                }else{
                    document.getElementById('quantidade-produto').value = 0;
                }
            }
        </script>
</body>

</html>