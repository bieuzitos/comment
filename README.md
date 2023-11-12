
# Comment

Este projeto oferece uma solução para a inclusão de recursos de comentários em websites e aplicativos.

## Instalação

**1. Atualizar dependências com Composer**

Certifique-se de que o Composer esteja instalado no seu ambiente de desenvolvimento. Se não estiver instalado, você pode encontrá-lo em [getcomposer.org](https://getcomposer.org/).

Para atualizar as dependências do Composer, execute o seguinte comando na raiz do seu projeto:

```bash
composer update
```

Isso garantirá que todas as bibliotecas e pacotes estejam atualizados para a versão mais recente de acordo com o arquivo `composer.json`.

**2. Executar script do Composer JSON (post-root-package-install)**

Para executar o script `post-root-package-install`, utilize o seguinte comando na raiz do seu projeto:

```bash
composer run-script post-root-package-install
```

Este script é responsável por gerar o arquivo `.env` necessário para a configuração do ambiente.

**3. Executar as Migrations e Seeders do Banco de Dados**

Use o seguinte comando para executar as migrations e seeders do banco de dados e preparar a estrutura do banco de dados:

```bash
composer run-script phinx-migrate-cmd
```

As migrations são responsáveis por criar as tabelas e a estrutura do banco de dados de acordo com as especificações do projeto.

Os seeders são responsáveis por adicionar registros iniciais ao banco de dados, como dados de exemplo ou informações iniciais.

## Funcionalidades

- Comentários Intuitivos
- Edição de Comentários
- Exclusão de Comentários

## Roadmap

- Sistema de Avaliação
- Respostas a Comentários
- Filtragem de Comentários

## Screenshots

![App Screenshot](https://raw.githubusercontent.com/bieuzitos/comment/main/public/assets/images/screenshot%20(1).jpg)
![App Screenshot](https://raw.githubusercontent.com/bieuzitos/comment/main/public/assets/images/screenshot%20(2).jpg)
![App Screenshot](https://raw.githubusercontent.com/bieuzitos/comment/main/public/assets/images/screenshot%20(3).jpg)
![App Screenshot](https://raw.githubusercontent.com/bieuzitos/comment/main/public/assets/images/screenshot%20(4).jpg)
![App Screenshot](https://raw.githubusercontent.com/bieuzitos/comment/main/public/assets/images/screenshot%20(5).jpg)