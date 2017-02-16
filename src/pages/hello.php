<?php $name = $request->get('name', 'World');?>
Hellos <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');?>