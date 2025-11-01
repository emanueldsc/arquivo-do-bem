import { createHashRouter } from "react-router-dom";
import { Layout } from "./components/Layout";
import { Page } from "./pages/Page";

export const router = createHashRouter([
  {
    path: "/",
    element: <Layout />,
    children: [
      {
        index: true,
        element: (
          <Page title="Home" subtitle="Bem-vindo à aplicação">
            <p>Conteúdo temporário da Home.</p>
          </Page>
        ),
      },
      {
        path: "repositorio",
        element: (
          <Page title="Repositório" subtitle="Arquivos e materiais">
            <ul>
              <li>Item A</li>
              <li>Item B</li>
            </ul>
          </Page>
        ),
      },
      {
        path: "gestao",
        element: (
          <Page title="Gestão de Projetos" subtitle="Quadros e tarefas">
            <p>Em breve: visão de projetos.</p>
          </Page>
        ),
      },
      {
        path: "professor",
        element: (
          <Page title="Painel do Professor" subtitle="Acesso docente">
            <p>Ferramentas do professor aqui.</p>
          </Page>
        ),
      },
      {
        path: "aluno",
        element: (
          <Page title="Painel do Aluno" subtitle="Acesso discente">
            <p>Atividades e notas do aluno.</p>
          </Page>
        ),
      },
    ],
  },
]);
