# UML Karsa Studio

Dokumentasi ini dibuat berdasarkan isi project Laravel **Karsa Studio**, yaitu aplikasi toko asset digital dengan fitur dashboard, autentikasi, katalog produk, detail produk, checkout, riwayat order user, dashboard admin, tambah katalog produk, status order, simulasi pembayaran, dan integrasi callback Midtrans.

## 1. Use Case Diagram

Aktor utama pada aplikasi ini adalah **Guest**, **User**, **Admin**, dan **Midtrans** sebagai sistem pembayaran eksternal.

```mermaid
flowchart LR
    Guest["Guest"]
    User["User Login"]
    Admin["Admin"]
    Midtrans["Midtrans"]

    subgraph App["Karsa Studio"]
        UC1(["Melihat Dashboard"])
        UC2(["Register Akun"])
        UC3(["Login Akun"])
        UC4(["Melihat Katalog"])
        UC5(["Melihat Detail Produk"])
        UC6(["Checkout Produk"])
        UC7(["Melihat Status Order"])
        UC8(["Simulasi Pembayaran"])
        UC9(["Download Produk Digital"])
        UC10(["Logout"])
        UC11(["Mengirim Callback Pembayaran"])
        UC12(["Melihat Riwayat Order"])
        UC13(["Melihat Dashboard Admin"])
        UC14(["Menambah Produk Katalog"])
    end

    Guest --> UC1
    Guest --> UC2
    Guest --> UC3
    Guest --> UC4
    Guest --> UC5

    User --> UC1
    User --> UC4
    User --> UC5
    User --> UC6
    User --> UC7
    User --> UC8
    User --> UC9
    User --> UC10
    User --> UC12

    Admin --> UC1
    Admin --> UC4
    Admin --> UC10
    Admin --> UC13
    Admin --> UC14

    Midtrans --> UC11
    UC11 --> UC7
    UC6 --> Midtrans
```

## 2. Activity Diagram Admin

Alur admin dipakai untuk masuk ke dashboard admin dan menambahkan produk katalog baru.

```mermaid
flowchart TD
    A([Mulai]) --> B[Admin login]
    B --> C{Akun admin?}
    C -- Tidak --> D[Akses ditolak 403]
    C -- Ya --> E[Dashboard Admin ditampilkan]
    E --> F[Admin klik Tambah Katalog]
    F --> G[Admin mengisi data produk]
    G --> H{Data valid?}
    H -- Tidak --> I[Tampilkan error validasi]
    I --> G
    H -- Ya --> J[Sistem membuat slug unik]
    J --> K{Upload gambar?}
    K -- Ya --> L[Simpan gambar ke public/images/products]
    K -- Tidak --> M[Gunakan image_path yang diisi]
    L --> N[Produk disimpan ke database]
    M --> N
    N --> O[Produk muncul di Dashboard Admin dan Katalog User]
    O --> P([Selesai])
```

## 3. Activity Diagram User

Alur utama aplikasi dimulai dari dashboard, masuk ke katalog, melihat detail produk, lalu checkout jika user sudah login.

    ```mermaid
    flowchart TD
        A([Mulai]) --> B[User membuka Dashboard]
        B --> C{Sudah login?}
        C -- Belum --> D[Login atau Register]
        D --> E[Dashboard menampilkan status akun]
        C -- Sudah --> E
    E --> F[User membuka Katalog]
        F --> G[User memilih Lihat Detail Produk]
        G --> H[Modal detail produk ditampilkan]
        H --> I{Lanjut checkout?}
        I -- Tidak --> F
        I -- Ya --> J{User sudah login?}
        J -- Belum --> D
        J -- Sudah --> K[Isi data checkout]
        K --> L[Sistem membuat Order]
        L --> M[Sistem membuat Order Item]
        M --> N[Sistem meminta Snap Token Midtrans]
    N --> O[User diarahkan ke Status Order]
    O --> P{Status pembayaran}
        P -- Pending --> Q[Bayar via Midtrans atau Simulasi Pembayaran]
        Q --> O
    P -- Paid --> R[Link download produk ditampilkan]
    P -- Expired atau Failed --> S[User dapat membuat order ulang]
    O --> U[Order tersimpan di Riwayat Order User]
    R --> T([Selesai])
    S --> T
    U --> T
    ```

## 4. Architecture Diagram

Arsitektur project memakai pola Laravel MVC dengan Blade untuk view, controller untuk proses bisnis, model Eloquent untuk database, dan service khusus untuk integrasi Midtrans.

```mermaid
flowchart TB
    Browser["Browser User"]

    subgraph Laravel["Laravel Application"]
        Routes["routes/web.php"]
        AuthController["AuthController"]
        AdminProductController["Admin ProductController"]
        OrderController["OrderController"]
        PaymentController["PaymentNotificationController"]
        MidtransService["MidtransService"]

        subgraph Views["Blade Views"]
            Dashboard["dashboard.blade.php"]
            Login["auth/login.blade.php"]
            Register["auth/register.blade.php"]
            Store["store.blade.php"]
            Status["status.blade.php"]
            History["orders/history.blade.php"]
            AdminDashboard["admin/dashboard.blade.php"]
            AdminCreate["admin/products/create.blade.php"]
            Layout["layouts/app.blade.php"]
        end

        subgraph Models["Eloquent Models"]
            User["User"]
            Product["Product"]
            Order["Order"]
            OrderItem["OrderItem"]
        end
    end

    Database[("Database")]
    Midtrans["Midtrans API / Callback"]

    Browser --> Routes
    Routes --> AuthController
    Routes --> AdminProductController
    Routes --> OrderController
    Routes --> PaymentController

    AuthController --> User
    AdminProductController --> Product
    AdminProductController --> Order
    OrderController --> Product
    OrderController --> Order
    OrderController --> OrderItem
    OrderController --> MidtransService
    PaymentController --> MidtransService
    PaymentController --> Order

    AuthController --> Login
    AuthController --> Register
    AdminProductController --> AdminDashboard
    AdminProductController --> AdminCreate
    OrderController --> Store
    OrderController --> Status
    OrderController --> History
    Routes --> Dashboard
    Views --> Layout

    User --> Database
    Product --> Database
    Order --> Database
    OrderItem --> Database

    MidtransService --> Midtrans
    Midtrans --> PaymentController
```

## 5. Class Diagram

Diagram class berikut mengikuti file model, controller, dan service yang ada di project.

```mermaid
classDiagram
    class AuthController {
        +showLogin() View
        +login(Request) RedirectResponse
        +showRegister() View
        +register(Request) RedirectResponse
        +logout(Request) RedirectResponse
    }

    class AdminProductController {
        +dashboard(Request) View
        +create(Request) View
        +store(Request) RedirectResponse
        -authorizeAdmin(Request) void
        -uniqueSlug(slug) string
    }

    class OrderController {
        -midtrans MidtransService
        +index()
        +checkout(Request)
        +status(order_id)
        +simulatePay(order_id, Request)
    }

    class PaymentNotificationController {
        -midtrans MidtransService
        +handle(Request)
    }

    class MidtransService {
        -serverKey
        -clientKey
        -isProduction
        -snapUrl
        +isConfigured() bool
        +getSnapToken(order) string
        +verifySignature(payload) bool
    }

    class User {
        +id
        +name
        +email
        +password
        +is_admin
        +remember_token
        +orders()
    }

    class Product {
        +id
        +name
        +slug
        +description
        +price
        +image_path
        +download_url
    }

    class Order {
        +id
        +user_id
        +customer_name
        +customer_email
        +customer_phone
        +total_price
        +status
        +snap_token
        +payment_type
        +transaction_id
        +items()
        +user()
    }

    class OrderItem {
        +id
        +order_id
        +product_id
        +price
        +order()
        +product()
    }

    AuthController --> User : create/login
    AdminProductController --> Product : create/read
    AdminProductController --> Order : count summary
    OrderController --> Product : read
    OrderController --> Order : create/read/update
    OrderController --> OrderItem : create
    OrderController --> MidtransService : request token
    PaymentNotificationController --> Order : update status
    PaymentNotificationController --> MidtransService : verify signature
    Order "1" --> "many" OrderItem : hasMany
    User "1" --> "many" Order : hasMany
    Order "many" --> "1" User : belongsTo
    Product "1" --> "many" OrderItem : referenced by
    OrderItem "many" --> "1" Order : belongsTo
    OrderItem "many" --> "1" Product : belongsTo
```

## 6. Sequence Diagram User Checkout

Sequence ini menggambarkan proses utama saat user membeli produk dari katalog sampai status order dibuat.

```mermaid
sequenceDiagram
    actor User
    participant Browser
    participant Routes as Laravel Routes
    participant OrderController
    participant Product
    participant Order
    participant OrderItem
    participant MidtransService
    participant Midtrans
    participant StatusView as Status Page

    User->>Browser: Buka katalog
    Browser->>Routes: GET /katalog
    Routes->>OrderController: index()
    OrderController->>Product: Product::all()
    Product-->>OrderController: daftar produk
    OrderController-->>Browser: store.blade.php

    User->>Browser: Klik Lihat Detail Produk
    Browser-->>User: Modal detail produk tampil
    User->>Browser: Klik Lanjut Checkout

    Browser->>Routes: POST /checkout
    Routes->>OrderController: checkout(request)
    OrderController->>Product: findOrFail(product_id)
    Product-->>OrderController: data produk
    OrderController->>Order: create(order with user_id)
    OrderController->>OrderItem: create(order item)
    OrderController->>MidtransService: getSnapToken(order)

    alt Midtrans configured
        MidtransService->>Midtrans: POST Snap transaction
        Midtrans-->>MidtransService: snap token
    else Midtrans not configured
        MidtransService-->>OrderController: simulated token
    end

    OrderController->>Order: update snap_token
    OrderController-->>Browser: redirect /order/{order_id}
    Browser->>Routes: GET /order/{order_id}
    Routes->>OrderController: status(order_id)
    OrderController->>Order: load order + items + product
    OrderController-->>StatusView: status.blade.php
    StatusView-->>User: Status pembayaran ditampilkan
```

## 7. Sequence Diagram Admin Tambah Katalog

Sequence ini menggambarkan proses saat admin menambahkan produk baru ke katalog.

```mermaid
sequenceDiagram
    actor Admin
    participant Browser
    participant Routes as Laravel Routes
    participant AdminProductController
    participant Product
    participant PublicImages as public/images/products
    participant AdminDashboard as Admin Dashboard

    Admin->>Browser: Buka /admin
    Browser->>Routes: GET /admin
    Routes->>AdminProductController: dashboard(request)
    AdminProductController->>AdminProductController: authorizeAdmin(request)
    AdminProductController->>Product: latest()->get()
    Product-->>AdminProductController: daftar produk
    AdminProductController-->>Browser: admin/dashboard.blade.php

    Admin->>Browser: Klik Tambah Katalog
    Browser->>Routes: GET /admin/katalog/tambah
    Routes->>AdminProductController: create(request)
    AdminProductController-->>Browser: admin/products/create.blade.php

    Admin->>Browser: Submit form produk
    Browser->>Routes: POST /admin/katalog
    Routes->>AdminProductController: store(request)
    AdminProductController->>AdminProductController: validate input
    AdminProductController->>AdminProductController: generate unique slug

    alt Admin upload gambar
        AdminProductController->>PublicImages: simpan file gambar
    else Admin isi path gambar
        AdminProductController->>AdminProductController: gunakan image_path
    end

    AdminProductController->>Product: create(product)
    Product-->>AdminProductController: produk tersimpan
    AdminProductController-->>AdminDashboard: redirect admin.dashboard
```

## 8. ERD / Database Diagram

Database utama project terdiri dari tabel users, products, orders, order_items, sessions, dan password_reset_tokens. Relasi transaksi utama berada pada orders, order_items, dan products.

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        boolean is_admin
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    PRODUCTS {
        bigint id PK
        string name
        string slug UK
        text description
        decimal price
        string image_path
        string download_url
        timestamp created_at
        timestamp updated_at
    }

    ORDERS {
        string id PK
        bigint user_id FK
        string customer_name
        string customer_email
        string customer_phone
        decimal total_price
        string status
        string snap_token
        string payment_type
        string transaction_id
        timestamp created_at
        timestamp updated_at
    }

    ORDER_ITEMS {
        bigint id PK
        string order_id FK
        bigint product_id FK
        decimal price
        timestamp created_at
        timestamp updated_at
    }

    PASSWORD_RESET_TOKENS {
        string email PK
        string token
        timestamp created_at
    }

    SESSIONS {
        string id PK
        bigint user_id
        string ip_address
        text user_agent
        longText payload
        integer last_activity
    }

    ORDERS ||--|{ ORDER_ITEMS : contains
    PRODUCTS ||--|{ ORDER_ITEMS : purchased_as
    USERS ||--o{ ORDERS : places
    USERS ||--o{ SESSIONS : may_have
```

## Catatan Batasan Sistem

- Admin sudah bisa menambah produk katalog, tetapi fitur edit dan hapus produk belum tersedia.
- Checkout hanya membeli satu produk per order.
- Order baru sudah terhubung ke tabel users melalui `orders.user_id`; data pelanggan tetap disimpan di tabel orders sebagai snapshot checkout.
- Jika kredensial Midtrans belum dikonfigurasi, sistem memakai token simulasi dan fitur `simulatePay`.
