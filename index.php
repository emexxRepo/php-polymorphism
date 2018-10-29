<?php
/* Kalıtım, bir sınıfın bir başka sınıftan türemesidir.
    Türemiş sınıf, kendisinden türediği sınıftan özellik ve metodları miras almaktadır ve kalıtım konusunda en önemli kavram, bu miras kavramıdır.

     Türemiş sınıf ile türetildiği sınıf arasında miras bağını oluşturan akrabalık vardır, buna “bir ilişkisi” de diyoruz. Türeyen sınıf aynı zamanda bir türetilen sınıftır. Daha önce çokça örneği geçtiği için tekrara düşmemek adına, bir ilişkisini basit bir örnek üzerinden tekrar gösterelim.

 */

namespace Polymorphism {
    interface IPeople
    {
        public function setProp(string $birthday, int $height, int $weight);

        public function getProp();

        public function setName(string $fullname);

        public function getName();
    }

    trait Slug
    {
        protected $slug;

        public function setSlug($str): void
        {
            //KARAKTERLERİ KÜÇÜLT
            $str = mb_strtolower($str, "UTF-8");
            //TÜRKÇE KARAKTERLERİ DÖNÜŞTÜR
            $str = str_replace(
                ['ı', 'ş', 'ü', 'ğ', 'ç', 'ö'],
                ['i', 's', 'u', 'g', 'c', 'o'],
                $str
            );
            $str = preg_replace('/[^a-z0-9]/', '-', $str);
            //HARF VE SAYILAR HARİÇ KARARAKTERLERİ - İŞARETİNE DÖNÜŞTÜR

            $str = preg_replace('/-+/', '-', $str);
           //BİRDEN FAZLA - İŞARETİNİ teke düşür

            $this->slug = trim($str,"-");
        }

        public function getSlug(): void
        {
            echo $this->slug;
        }
    }

    class People implements IPeople
    {
        protected $birthDay;
        protected $height;
        protected $weight;
        protected $firstAndLastName = array();
        use Slug; //INCLUDING TRAİT

        /*
         Burada gerçekleşen olay aslında gayet basit. Trait içerisindeki yöntem ve değişkenler, use ile trait'i kullandığınız classlara, compile(derleme) anında aynen aktarılıyor. Böylece hem class'larınızı herhangi bir şekilde birbirine bağlamamış oluyorsunuz, hem de bu örnekteki gibi alakasız iki ayrı sınıfın ortak kullandığı bir yöntemi, kendinizi tekrar etmeden uygulayabiliyorsunuz.*/

        public function setProp(string $birthday, int $height, int $weight): void
        {
            $this->birthDay = $birthday;
            $this->height = $height;
            $this->weight = $weight;
        }

        public function getProp(): void
        {
            echo $this->birthDay . PHP_EOL;
            echo $this->height . PHP_EOL;
            echo $this->weight . PHP_EOL;
        }

        public function setName(string $fullname): void
        {
            $parseNames = explode(' ', $fullname);
            $this->firstAndLastName['firstName'] = $parseNames[0];
            $this->firstAndLastName['lastName'] = $parseNames[1];
        }

        public function getName(): void
        {
            print_r($this->firstAndLastName);
        }

    }

    class Man extends People
    {

    }

    class Woman extends People
    {

    }
}

namespace newHuman {
    echo "<hr>";
    $man = new \Polymorphism\Man();
    $man->setProp("28.01.1997", 180, 79); //BİR ADAM YARATTIK
    $man->setName("Murat Topuz");
    $man->getProp();
    $man->getName();
    $man->setSlug("Murat Topuz");
    $man->getSlug();

    echo "<hr>";
    $woman = new \Polymorphism\Woman();
    $woman->setProp("12.06.1997", 178, 62); //BİR KADIN YARATTIK
    $woman->setName("ELA Kadir");
    $woman->getSlug();
    $woman->getProp();
    $woman->getName();
    $woman->setSlug("ELA Kadir");
    $woman->getSlug();
}