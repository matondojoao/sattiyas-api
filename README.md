<h1 align="justify">
Essence Shop API
</h1>

<p align="justify">
Construída no Laravel, a Essence Shop API capacita sua plataforma de e-commerce com módulos essenciais, como Produtos, Categorias, Imagens de Produtos e Autenticação.

**Autenticação:** A Essence Shop utiliza o Sanctum para autenticação segura. Para testar no Postman, consulte a [Documentação da API](https://laravel.com/docs/9.x/sanctum#main-content) sobre como autenticar usando Sanctum.

**Pagamentos:** A Essence Shop integra-se ao Stripe para processar pagamentos. Confira o [repositório GitHub do Stripe PHP](https://github.com/stripe/stripe-php) para mais detalhes sobre o processamento de pagamentos com o Stripe.

**Caching:** A Essence Shop utiliza o Redis para caching para melhorar o desempenho e a escalabilidade.

---

### Módulos

#### Autenticação (Auth)
- Gerencia a autenticação do usuário, incluindo login, registro e logout.

#### Redefinição de Senha (ResetPassword)
- Manipula a funcionalidade de redefinição de senha, incluindo o envio de links de redefinição e a redefinição de senhas.

#### Perfil (Profile)
- Gerencia os perfis dos clientes.

#### Lista de Desejos (Wishlist)
- Permite que os usuários adicionem e removam itens de sua lista de desejos.

#### Pedido (Order)
- Gerencia os pedidos dos clientes, incluindo a realização de pedidos e a recuperação do histórico de pedidos.

#### Avaliação (Review)
- Gerencia as avaliações de produtos enviadas pelos usuários.

### Acesso Público

#### Produto (Product)
- Fornece acesso público às informações do produto.

#### Categoria (Category)
- Oferece acesso público às categorias de produtos.

#### Carrinho (Cart)
- Gerencia o carrinho de compras do usuário, incluindo a adição e remoção de itens.

#### Cupom (Coupon)
- Gerencia a aplicação de cupons pelos usuários.

#### Opção de Entrega (Delivery Option)
- Fornece informações sobre opções de entrega disponíveis.

#### Método de Pagamento (Payment Method)
- Fornece informações sobre métodos de pagamento disponíveis.

### Operações de Administração

#### Categoria de Administração (Admin Category)
- Funcionalidade de administração para criar, atualizar e excluir categorias de produtos.

#### Pedido de Administração (Admin Order)
- Funcionalidade de administração para visualizar, atualizar e excluir pedidos.
- Gera relatórios de vendas.

#### Opção de Entrega de Administração (Admin Delivery Option)
- Funcionalidade de administração para gerenciar opções de entrega.

#### Método de Pagamento de Administração (Admin Payment Method)
- Funcionalidade de administração para gerenciar métodos de pagamento.

#### Produto de Administração (Admin Product)
- Funcionalidade de administração para gerenciar produtos, incluindo criação, atualização e exclusão.

#### Cliente de Administração (Admin Customer)
- Funcionalidade de administração para gerenciar informações do cliente.
- Gera relatórios de clientes.

#### Estoque (Stock)
- Funcionalidade de administração para gerenciar estoques de produtos.

#### Cupom de Administração (Admin Coupon)
- Funcionalidade de administração para gerenciar cupons.

#### Relatórios (Reports)
- Acesso a vários relatórios, incluindo relatórios de vendas e relatórios de clientes.
---

### Tecnologias Utilizadas

- Laravel: Um poderoso framework PHP para construir aplicações web robustas.
- MySQL: Um banco de dados relacional confiável para armazenamento de dados.
- Laravel Sanctum: Para autenticação de API.
- Redis: Armazenamento de estrutura de dados em memória para caching.

### Começando

1. Clone o repositório: `https://github.com/matondojoao/essence-shop-api.git`
2. Instale as dependências: `composer install`
3. Configure seu banco de dados e atualize o arquivo `.env`.
4. Execute as migrações: `php artisan migrate`
5. Inicie o servidor de desenvolvimento: `php artisan serve`

Para documentação detalhada da API, visite <a href="" target="_blank">Documentação da API</a>.

---

### Contribuidores

- [Matondo João](https://github.com/matondojoao)

Sinta-se à vontade para contribuir e tornar a API da Essence Shop ainda melhor!
</p>
