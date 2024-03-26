<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estoque</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .green {
            background-color: #99ff7b;
        }

        .orange {
            background-color: #febc5a;
        }

        .red {
            background-color: #ff2d2d;
        }
    </style>
</head>
<body>
    <h2>Lista de Estoque</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome do Produto</th>
            <th>Quantidade Mínima</th>
            <th>Quantidade Atual</th>
        </tr>
        <?php
        $servername = "localhost";
        $port = 3306;
        $username = "root";
        $password = "";
        $dbname = "banco_de_dados";

        try {
            $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM estoque";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $quantidade_atual = $row['quantidade_atual'];
                $quantidade_min = $row['quantidade_min'];

                if ($quantidade_atual > $quantidade_min) {
                    $class = "green";
                } elseif ($quantidade_atual == $quantidade_min) {
                    $class = "orange";
                } else {
                    $class = "red";
                }

                echo "<tr class='$class'>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['nome_produto']}</td>";
                echo "<td>{$row['quantidade_min']}</td>";
                echo "<td>{$row['quantidade_atual']}</td>";
                echo "</tr>";
            }
        } catch(PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }

        $conn = null;
        ?>
    </table>
</body>
</html>