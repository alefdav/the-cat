# The Cat Theme

## Pré-requisitos

- Node.js >= 6.9.0
- NPM >= 6.0.0

## Dependências Principais

- node-sass: ^9.0.0
- popper.js: ^1.16.1 
- typed.js: ^2.1.0

## Dependências de Desenvolvimento

- @babel/core: ^7.26.0
- @babel/preset-env: ^7.26.0
- webpack: ^5.97.1
- webpack-cli: ^6.0.1
- webpack-dev-server: ^5.2.0

## Uso

1. Clone o repositório

2. Instale as dependências:

```bash
npm install
```

3. Faça o build do projeto:

- Local/Homologação
```bash
npm run dev
```

- Produção
```bash
npm run prod
```

## Estrutura do Projeto

O projeto utiliza:
- Babel para transpilação de JavaScript moderno
- Webpack para bundling e gerenciamento de assets
- SASS para estilização avançada
- ESLint para garantir qualidade do código
- Webpack Dev Server para desenvolvimento local
- `assets/js/`: Contém os arquivos de javascript do projeto.
- `assets/scss/`: Contém os arquivos de sass do projeto.
- `assets/img/`: Contém os arquivos de imagens do projeto.
- `inc/`: Contém os arquivos que incluem funcionalidades do projeto.
- `pages/`: Contém os arquivos de páginas do projeto.
- `template-parts/`: Contém os arquivos que incluem partes do projeto.
- `package.json`: Contém as dependências do projeto e scripts para rodar o projeto. 

## Compatibilidade

O projeto é configurado para suportar navegadores modernos através do @babel/preset-env.


## Contribuição

- Faça um fork do projeto
- Crie uma branch para sua feature: `git checkout -b minha-feature`
- Faça commit das suas alterações: `git commit -m 'Adiciona minha feature'`
- Faça push para a branch: `git push origin minha-feature`
- Abra um Pull Request

## Licença  

Este projeto está licenciado sob a licença MIT - veja o arquivo LICENSE para mais detalhes.

