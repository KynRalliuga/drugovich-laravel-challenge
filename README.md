# Setup utilizado

- Windows 10 (Debian Terminal)
- Docker
- Laravel
- Isomnia (Documentação e testes de requisições)

# Run

Para rodar o projeto você pode utilizar o docker, para isso você precisa ter ele instalado, você pode descobrir como instalar em sua máquina através do link odicial do docker:
https://docs.docker.com/get-started/

Para rodar o projeto com o docker é só navegar para a pasta de instalação do projeto e rodar o comando:

```shell
docker-compose up
docker exec drugovich-laravel-challenge php artisan migrate:fresh --seed
```

Após o comando ser executado você pode entrar pelo seu navegador no site http://localhost para verificar se a aplicação está rodando corretamente.

# Documentação / End-points

Você pode verificar todos os endpoints usando o programa Insomnia (https://insomnia.rest/) e importando o arquivo docs_insomnia.json presente no projeto.