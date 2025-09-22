<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommerceTables extends Migration
{
    public function up(): void
    {
        // Tabla roles
        Schema::create('rol', function (Blueprint $table) {
            $table->id('id_rol'); // bigIncrements id_rol
            $table->string('nombre');
            $table->timestamps();
        });

        // Tabla usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre');
            $table->string('correo')->unique();
            $table->string('password_usu');
            $table->unsignedBigInteger('id_rol');
            $table->foreign('id_rol')->references('id_rol')->on('rol')->onDelete('restrict');
            $table->timestamps();
        });

        // Tabla direccion_envio
        Schema::create('direccion_envio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('departamento');
            $table->string('pais');
            $table->string('telefono');
            $table->timestamps();
        });


        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre');
            $table->timestamps();
        });

        // Tabla productos
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad')->default(0);
            $table->string('imagen');
            $table->string('talla')->nullable();
            $table->string('color')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
            $table->timestamps();
        });


        // Tabla imagenes_producto
        Schema::create('imagenes_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->string('url_imagen');
            $table->timestamps();
        });

        // Tabla carrito
        Schema::create('carrito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->timestamps();
        });

        // Tabla comentarios
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->text('comentario');
            $table->tinyInteger('calificacion');
            $table->timestamps();
        });

        // Tabla favoritos
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->timestamp('updated_at')->useCurrent();
        });

        // Tabla cupones
        Schema::create('cupones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_cupon');
            $table->string('descripcion');
            $table->enum('tipo_descuento', ['porcentaje', 'valor']);
            $table->decimal('valor_descuento', 8, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Tabla pedidos
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->text('descripcion_pedido')->nullable();
            $table->decimal('total_pedido', 10, 2);
            $table->string('metodo_pago');
            $table->string('direccion_entrega');
            $table->string('telefono_contacto');
            $table->string('estados')->default('pendiente');
            $table->timestamps();
        });

        // Tabla pedido_producto
        Schema::create('pedido_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_pedido')->references('id_pedido')->on('pedidos')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 8, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // Tabla envios
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id_pedido')->on('pedidos')->onDelete('cascade');
            $table->string('empresa_envio');
            $table->string('numero_guia');
            $table->string('estado_envio');
            $table->date('fecha_envio');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->timestamps();
        });

        // Tabla historial_pedidos
        Schema::create('historial_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id_pedido')->on('pedidos')->onDelete('cascade');
            $table->string('estado_anterior');
            $table->string('estado_nuevo');
            $table->text('comentario')->nullable();
            $table->timestamp('fecha_cambio')->useCurrent();
        });

        // Tabla inventario
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->string('talla');
            $table->string('color');
            $table->integer('stock');
            $table->timestamps();
        });

        // Tabla pagos
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id_pedido')->on('pedidos')->onDelete('cascade');
            $table->string('metodo_pago');
            $table->string('estado_pago');
            $table->string('referencia_pago')->nullable();
            $table->decimal('monto', 10, 2);
            $table->timestamp('fecha_pago')->useCurrent();
        });

        // Tabla iva
        Schema::create('iva', function (Blueprint $table) {
            $table->id();
            $table->decimal('porcentaje', 5, 2);
            $table->timestamps();
        });

        // Tabla ventas
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('id_venta');
            $table->unsignedBigInteger('id_usuario');
            $table->decimal('total', 10, 2);
            $table->decimal('iva_total', 10, 2)->nullable();
            $table->timestamp('fecha_venta');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla detalle_venta
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_producto');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->foreign('id_venta')->references('id_venta')->on('ventas')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla compras
        Schema::create('compras', function (Blueprint $table) {
            $table->id('id_compra');
            $table->unsignedBigInteger('id_usuario');
            $table->decimal('total', 10, 2);
            $table->decimal('iva_total', 10, 2)->nullable();
            $table->timestamp('fecha_compra');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla detalle_compra
        Schema::create('detalle_compra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_compra');
            $table->unsignedBigInteger('id_producto');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->foreign('id_compra')->references('id_compra')->on('compras')->onDelete('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_compra');
        Schema::dropIfExists('compras');
        Schema::dropIfExists('detalle_venta');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('iva');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('inventario');
        Schema::dropIfExists('historial_pedidos');
        Schema::dropIfExists('envios');
        Schema::dropIfExists('pedido_producto');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('cupones');
        Schema::dropIfExists('favoritos');
        Schema::dropIfExists('comentarios');
        Schema::dropIfExists('carrito');
        Schema::dropIfExists('imagenes_producto');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('direccion_envio');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('rol');
    }
}
