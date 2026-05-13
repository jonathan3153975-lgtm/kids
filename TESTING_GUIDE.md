# 🧪 GUIA DE TESTES - JOGO CAÇA LETRAS

**Objetivo:** Validar funcionalidades, responsividade e usabilidade do jogo

---

## 📋 Checklist de Testes Manuais

### 1. ACESSO E CARREGAMENTO

- [ ] Acessar `http://localhost:8000/games/alphabet` no navegador
- [ ] Página carrega sem erros (inspecionar console)
- [ ] Jogo exibe tela inicial com "Caça Letras"
- [ ] Botão "Jogar Agora" aparece visível
- [ ] Botão "Voltar" está funcional

### 2. TELA INICIAL (MENU)

- [ ] Título "Caça Letras" está visível
- [ ] Instruções aparecem em português claro
- [ ] Nuvens decorativas aparecem no topo
- [ ] Botão "JOGAR AGORA" com cor verde
- [ ] Ao clicar em "Jogar Agora", inicia o jogo

### 3. GAMEPLAY - PRIMEIRA RODADA

- [ ] Letra alvo aparece no topo (em vermelho)
- [ ] 8 letras aleatórias aparecem na tela
- [ ] Letras estão bem distribuídas (sem sobreposição)
- [ ] Timer inicia em 60 segundos
- [ ] Pontos começam em 0
- [ ] Letra correta é diferente das outras

### 4. INTERAÇÃO - CLIQUE CORRETO

- [ ] Clicar na letra correta
- [ ] Animação de sucesso executa (scale + flash)
- [ ] Partículas verdes aparecem
- [ ] Pontos aumentam (5-10 pontos)
- [ ] Nova rodada inicia com nova letra
- [ ] Contador de acertos aumenta
- [ ] Nenhuma mensagem de erro

### 5. INTERAÇÃO - CLIQUE INCORRETO

- [ ] Clicar na letra incorreta
- [ ] Tela faz shake (tremida)
- [ ] Botão faz animação de erro
- [ ] Pontos PODEM diminuir (conforme implementação)
- [ ] Mesma letra continua na tela
- [ ] Contador de erros aumenta
- [ ] Possibilidade de tentar novamente

### 6. TIMER E FLUXO

- [ ] Timer diminui a cada segundo
- [ ] Após 60 segundos, jogo encerra
- [ ] Tela de recompensa aparece
- [ ] Não há crash ou erro

### 7. TELA DE RECOMPENSA

- [ ] Título "Parabéns! 🎉" aparece
- [ ] Estrelas aparecem (0-3 baseado em taxa de acerto)
- [ ] Estatísticas mostram:
  - [ ] Pontos finais
  - [ ] Total de acertos
  - [ ] Total de erros
  - [ ] Taxa de acerto em %
- [ ] Botão "JOGAR NOVAMENTE" funciona
- [ ] Botão "VOLTAR" funciona

### 8. BOTÃO VOLTAR

- [ ] Clique em "Voltar" na tela de recompensa
- [ ] Volta para página de jogos (`/games`)
- [ ] Dados da sessão anterior não persistem
- [ ] Nova partida começa do zero se jogar novamente

### 9. RESPONSIVIDADE - DESKTOP

- [ ] Testado em 1920x1080 (full HD)
- [ ] Testado em 1280x720 (padrão)
- [ ] Layout adapta corretamente
- [ ] Letras proporcionais
- [ ] Botões clicáveis
- [ ] Sem elementos cortados

### 10. RESPONSIVIDADE - TABLET

- [ ] Testado em 1024x768 (iPad landscape)
- [ ] Testado em 768x1024 (iPad portrait)
- [ ] Jogo redimensiona corretamente
- [ ] Botões grandes o suficiente para toque
- [ ] Sem scroll desnecessário
- [ ] UI clara e legível

### 11. RESPONSIVIDADE - MOBILE

- [ ] Testado em 480x800 (small phone)
- [ ] Testado em 375x667 (iPhone)
- [ ] Testado em 414x896 (iPhone 11+)
- [ ] Botões mínimo 80px de diâmetro
- [ ] Espaçamento adequado entre letras
- [ ] Sem elementos truncados
- [ ] Rotação de tela funciona (landscape/portrait)

### 12. PERFORMANCE

- [ ] Jogo roda a 60 FPS constante
- [ ] Nenhum lag ao clicar
- [ ] Transições suaves
- [ ] Memory não cresce indefinidamente
- [ ] Console sem avisos críticos

### 13. COMPATIBILIDADE DE NAVEGADORES

- [ ] Chrome/Chromium (última versão)
- [ ] Firefox (última versão)
- [ ] Safari (última versão)
- [ ] Edge (última versão)
- [ ] Firefox Mobile
- [ ] Chrome Mobile

### 14. ACESSIBILIDADE

- [ ] Texto suficientemente grande (legível)
- [ ] Cores com contraste elevado
- [ ] Sem elementos agressivos
- [ ] Feedback visual e textual
- [ ] Nenhum som obrigatório
- [ ] Tab order funciona (teclado)

### 15. CONSOLE (Developer Tools)

- [ ] Nenhum erro de JavaScript
- [ ] Nenhum aviso crítico
- [ ] Phaser carrega corretamente
- [ ] Sem problemas de CORS
- [ ] Mensagens de log informativas
- [ ] Sem memory leaks (Chrome DevTools)

---

## 🎯 Cenários de Teste Avançados

### Cenário 1: Sessão Rápida
1. Iniciar jogo
2. Clicar em 5 letras corretas rapidamente
3. Deixar timer chegar a 0
4. Validar pontuação e estrelas

### Cenário 2: Muitos Erros
1. Iniciar jogo
2. Clicar em letras incorretas
3. Eventualmente acertar algumas
4. Validar taxa de acerto
5. Validar número de estrelas

### Cenário 3: Redimensionamento Dinâmico
1. Iniciar jogo em desktop
2. Redimensionar janela
3. Validar que layout se adapta
4. Continuar jogando sem problemas
5. Redimensionar novamente

### Cenário 4: Mudança de Abas
1. Iniciar jogo
2. Alternar para outra aba
3. Voltar para o jogo
4. Validar que jogo continua funcionando
5. Timer ainda funciona (se implementado com requestAnimationFrame)

---

## 🐛 Bugs Conhecidos para Investigar

- [ ] Som não reproduz (áudio não integrado)
- [ ] Dados não salvam em BD (API não conectada)
- [ ] Sem limite de erros (mecânica futura)
- [ ] Sem sistema de vidas (mecânica futura)

---

## 📊 Métricas de Sucesso

| Métrica | Target | Status |
|---------|--------|--------|
| FPS Consistente | 60 FPS | 🔄 Validar |
| Tempo Carregamento | < 2s | 🔄 Validar |
| Taxa de Acerto > 50% | ✓ | 🔄 Validar |
| Compatibilidade Navegadores | 5+ | 🔄 Validar |
| Responsividade | 3+ breakpoints | 🔄 Validar |
| Acessibilidade Base | WCAG AA | 🔄 Validar |

---

## 🧑‍💻 Testes com Crianças (Futura)

Quando integrar com crianças reais:

- [ ] Teste com grupo de 3-5 crianças (4-7 anos)
- [ ] Observar naturalmente como usam (sem instruções)
- [ ] Medir tempo de compreensão
- [ ] Validar dificuldade apropriada
- [ ] Coletar feedback através de pais
- [ ] Medir taxa de conclusão de sessão
- [ ] Identificar confusões visuais

---

## 📝 Notas de Tester

```
Data do Teste: ___________
Tester: ___________
Navegador/Versão: ___________
Dispositivo: ___________
Resolução: ___________

Observações Gerais:
_____________________________________

Bugs Encontrados:
_____________________________________

Sugestões de Melhoria:
_____________________________________

Rating Geral: _____ / 10
```

---

## ✅ Definição de "Pronto para Produção"

O jogo será considerado pronto quando:

1. ✅ Todos os testes acima passarem
2. ✅ Sem erros críticos em console
3. ✅ Responsivo em 3+ dispositivos
4. ✅ 60 FPS constante
5. ✅ Feedback de 3+ testadores
6. ✅ Áudios integrados (se aplicável)
7. ✅ API conectada (se aplicável)

---

**Última Atualização:** 12/05/2026  
**Status:** Pronto para Testes Iniciais 🚀
