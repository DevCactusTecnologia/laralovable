# Plano de migração: Laravel 10 → 12

Pular direto do 10 para o 12 não é suportado pelo Composer/Laravel. É preciso passar pelo 11 primeiro, validar, e então subir para o 12. Cada salto altera dezenas de arquivos do esqueleto da aplicação.

## Pré-requisitos de ambiente
- **PHP 8.3+** instalado no servidor (obrigatório para Sentinel 9 e recomendado para Laravel 12).
- **Composer 2.7+**.
- Banco de dados com backup recente antes de rodar `migrate`.
- Branch dedicada `upgrade/laravel-12` — nada vai para `main` antes do checklist passar.

## Compatibilidade dos pacotes terceiros (verificado no Packagist)

| Pacote | Atual | Alvo L12 | Observação |
|---|---|---|---|
| laravel/framework | 10.48 | ^12.0 | — |
| cartalyst/sentinel | 7.0 | ^9.0 | PHP 8.3; revisar API de autenticação |
| yajra/laravel-datatables-oracle | 10.11 | ^12.0 | Verificar breaking changes em colunas |
| elibyy/tcpdf-laravel | 10.0 | ^10.0 | Já compatível |
| simplesoftwareio/simple-qrcode | 4.2 | ^4.2 | OK |
| guzzlehttp/guzzle | 7.9 | ^7.9 | OK |
| laravel/tinker | 2.10 | ^2.10 | OK |
| spatie/laravel-ignition | 2.0 | substituído pelo `laravel/pail` em L11+ |
| nunomaduro/collision | 7.0 | ^8.0 | — |
| phpunit/phpunit | 10.0 | ^11.0 | — |

## Fase 1 — Laravel 10 → 11 (esqueleto novo)

Mudança mais invasiva. Laravel 11 eliminou:
- `app/Http/Kernel.php`
- `app/Console/Kernel.php`
- `app/Http/Middleware/*` padrão
- `app/Exceptions/Handler.php`
- `config/auth.php`, `config/cache.php`, etc. (passam a usar defaults)

Tudo isso passa a ser configurado em **`bootstrap/app.php`** via fluent API.

Passos:
1. Bumps no `composer.json`:
   - `"php": "^8.2"`
   - `"laravel/framework": "^11.0"`
   - `"cartalyst/sentinel": "^8.0"` (versão de L11)
   - `"yajra/laravel-datatables-oracle": "^11.0"`
   - dev: `nunomaduro/collision: ^8.0`, `phpunit/phpunit: ^11.0`
2. Reescrever `bootstrap/app.php` no formato L11 (rotas, middleware, exceptions).
3. Migrar middleware customizado de `app/Http/Kernel.php` para registro fluente.
4. Migrar comandos agendados de `app/Console/Kernel.php` para `routes/console.php` ou closure em `withSchedule()`.
5. Migrar handlers de exceção de `app/Exceptions/Handler.php` para `withExceptions()`.
6. Apagar os Kernels e o Handler antigos (depois de migrar).
7. Atualizar adapter do Sentinel (a API muda pouco, mas `ServiceProvider` e config publicados podem precisar republicar).
8. `composer update`, `php artisan config:clear`, `php artisan route:list` para validar.

## Fase 2 — Laravel 11 → 12

Salto mais leve (Laravel 12 é evolução incremental do 11):
1. `"laravel/framework": "^12.0"`
2. `"cartalyst/sentinel": "^9.0"` (requer PHP 8.3 — subir PHP se ainda em 8.2)
3. `"yajra/laravel-datatables-oracle": "^12.0"`
4. `composer update`
5. Rodar `php artisan about` e validar versões.

## Riscos altos a confirmar antes de começar

1. **Sentinel é o coração da auth**. A migração de 7 → 8 → 9 pode mexer em assinaturas de `Activation`, `Reminder`, `Role`, `Permission`. Cada controller que usa `Sentinel::` precisa ser revisado. Há centenas de chamadas no projeto.
2. **Datatables 10 → 11 → 12**: a forma de retornar JSON e colunas raw mudou. Toda tela com DataTable precisa ser testada manualmente.
3. **Views Blade**: nenhuma quebra esperada, mas as melhorias visuais (s-modern, s-result-create) usam padrões neutros que devem continuar funcionando.
4. **PHP 8.3** quebra `creation_of_dynamic_property` para classes não-`#[AllowDynamicProperties]`. Models e classes da app podem precisar de ajustes.
5. **Não posso rodar `composer update` no sandbox** (não há PHP/composer disponíveis aqui). As mudanças serão feitas nos arquivos; você precisa executar `composer update` localmente/no servidor e me reportar a saída para eu corrigir o que falhar.

## Estratégia de validação

Depois de cada fase:
- `composer update` sem erros
- `php artisan about` mostrando a versão alvo
- `php artisan route:list` lista todas as rotas
- Login funcional (Sentinel)
- Tela "Inserir Resultado" abre e salva
- Pelo menos uma DataTable carrega
- Imprimir exame / Imprimir todos funcionam

## Entregáveis por fase

**Fase 1 (PR 1):** composer.json atualizado, novo `bootstrap/app.php`, remoção de Kernels, ajustes de Sentinel 8, ajustes de Datatables 11.

**Fase 2 (PR 2):** bumps para Laravel 12, Sentinel 9, Datatables 12.

## Decisão necessária antes de começar

Confirme:
1. Pode rodar `composer update` no seu ambiente local/servidor e me passar a saída? (sem isso, não consigo validar nada de runtime).
2. PHP do servidor de produção está em qual versão hoje? (precisa ir para 8.3).
3. Quer que eu execute as duas fases em sequência, ou parar após a Fase 1 para você validar em homologação antes de prosseguir para o 12?
