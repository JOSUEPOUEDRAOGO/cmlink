<section class="legal-section">

    <div class="container">

        <div class="legal-wrapper">

            <article class="legal-card">

                {!! $page->content !!}

            </article>

        </div>

    </div>

</section>

<style>

.legal-hero{

    padding:120px 0 70px;

    background:
    radial-gradient(circle at top left,rgba(30,74,118,.12),transparent 40%),
    radial-gradient(circle at right,rgba(20,184,166,.08),transparent 35%),
    linear-gradient(180deg,#f8fbff 0%,#ffffff 100%);
}

.legal-hero-content{

    max-width:850px;

    margin:auto;

    text-align:center;
}

.legal-badge{

    display:inline-flex;

    align-items:center;

    padding:10px 18px;

    border-radius:999px;

    background:#eaf7ff;

    color:#1e4a76;

    font-weight:700;

    margin-bottom:25px;
}

.legal-hero h1{

    font-size:3rem;

    font-weight:900;

    color:#07131f;

    margin-bottom:20px;
}

.legal-hero p{

    color:#64748b;

    font-size:1.05rem;
}

.legal-section{

    padding:80px 0;
}

.legal-wrapper{

    max-width:950px;

    margin:auto;
}

.legal-card{

    background:#fff;

    border-radius:26px;

    padding:60px;

    box-shadow:
    0 15px 45px rgba(15,23,42,.08);

    border:1px solid #eef2f7;
}

.legal-card h2{

    margin-top:45px;

    margin-bottom:18px;

    color:#0f172a;

    font-weight:800;
}

.legal-card h3{

    margin-top:32px;

    margin-bottom:14px;

    color:#1e4a76;

    font-weight:700;
}

.legal-card p{

    line-height:2;

    color:#475569;

    margin-bottom:18px;
}

.legal-card ul{

    margin-left:25px;

    margin-bottom:25px;
}

.legal-card li{

    margin-bottom:12px;

    color:#475569;
}

@media(max-width:768px){

.legal-hero{

padding:90px 0 50px;

}

.legal-hero h1{

font-size:2.1rem;

}

.legal-card{

padding:30px;

border-radius:18px;

}

}

</style>
