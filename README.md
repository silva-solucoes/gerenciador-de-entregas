Lajes@prefeitura2025

fazer o deploy na hostinger: https://dev.to/danroxha/deploy-automatico-na-hostinger-com-projeto-laravel-e-github-2bch

Vídeo: https://www.youtube.com/watch?v=Yl1yrRCxnPE
## PROJETO WEB PARA PREFEITURA MUNICIPAL DE LAJES - GERENCIADOR DE ENTREGAS DE ABADÁS
<p align="center">
  <a href="https://boralajear.com.br/" target="_blank">
    <img src="public/img/logo-evento.png" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Status de construção"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total de downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Última versão estável"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="Licença"></a>
</p>

## SOBRE O PROJETO

O presente sistema foi desenvolvido para gerenciar o controle de entrega de abadás durante o Carnaval de Todos de 2025 em Lajes, garantindo organização e evitando duplicidade no cadastro e na entrega. Ele permite:

- ✅ Cadastro de foliões com nome e CPF, assegurando que cada pessoa receba seu abadá corretamente.
- ✅ Entrega controlada por operadores, impedindo que um mesmo CPF receba múltiplas vezes.
- ✅ Relatórios detalhados com histórico de entregas, permitindo acompanhamento da distribuição.
- ✅ Gerenciamento de usuários com diferentes níveis de acesso, garantindo segurança e controle.
- ✅ Interface amigável para facilitar o uso por administradores e operadores.

O sistema utiliza Laravel 11 com MySQL para armazenar os dados de forma segura. Além disso, conta com um painel administrativo para gerenciar usuários, alterar status de foliões e gerar relatórios personalizados. Tudo isso visa garantir um Carnaval mais organizado e eficiente para os foliões e organizadores. 🎭🎊

## BAIXEI O PROJETO, COMO FAÇO PARA RODÁ-LO?

### Requisitos 

- Laravel 11
- PHP 8.2 ou superior
- MySQL
- Composer
- GIT

### Comandos iniciais

Terminal: Comando para instalar as dependências
```
composer instal
```

Duplicar o arquivo ".env.example" e renomear para ".env"

Terminal: Comando para gerar a chave
```
php artisan key:generate
```

Terminal: Comando para iniciar o projeto criado com o Laravel
```
php artisan serve
```

Terminal: Comando para acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000/
```

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
