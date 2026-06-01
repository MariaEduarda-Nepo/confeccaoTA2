- [x] Ler contexto do fluxo de criação de pedidos (`CreatePedido.php`) e da notificação existente (`PedidoCriadoNotification.php`).
- [x] Ajustar `PedidoCriadoNotification` para receber o `Pedido` e montar um email de confirmação com número/status/valor.
- [x] Disparar a notificação no `afterCreate()` do `CreatePedido`, enviando para o cliente vinculado ao pedido (via `cliente->email`).

