<?php

namespace Database\Seeders;

use App\Models\Estudio;
use App\Models\Reto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RetoSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $estudios = Estudio::get();

    $retos = [
        [
            'titulo' => 'Merchandising de la Liga',
            'texto' => 'Desde la familia profesional de Textil, Confección y Piel el IES Besaya a través de su ciclo Profesional Básico en Tapicería y Cortinaje ha diseñado el RETO de Merchadising. Este RETO tiene la finalidad de diseñar y confeccionan productos de merchandising como chapas, llaveros, gorras con los logos de la Liga, centros participantes y diseños exclusivos para la venta y recaudación de fondos destinados a nuestra ONG. La venta se realizará en el propio reciento del evento durante los días 12 y 13 de marzo. Para ello se instalará una expositor tienda dentro del propio recinto.',
            'estudio_id' => $estudios->first()->id,
        ],
        [
            'titulo' => 'FoodTruck',
            'texto' => 'Desde la familia profesional de Hostelería y Turismo el IES Besaya a través de sus ciclos Profesionales Básico en Cocina y Restauracion y Grado Medio en Servicios de Restauracion han diseñado el RETO de Food truck. Este RETO tiene la finalidad de diseñar y producir bebidas isotónicas y barritas energéticas para la venta y recaudación de fondos destinados a nuestra ONG. La venta se realizará en el propio reciento del evento durante los días 12 y 13 de marzo. Para ello se instalará una foodtruck en los aledaños del recinto.',
            'estudio_id' => $estudios->get(1)->id,
        ],
        [
            'titulo' => 'Diseño de Logos, etiquetas, packering',
            'texto' => 'Desde la familia profesional de Comercio y Marketing el IES Besaya a través de sus ciclos Grado Medio en Comercialización de Productos Alimentarios y Grado Superior en Transporte y Logística han diseñado el RETO de Logos, etiquetas, packering. Este RETO tiene la finalidad de diseñar el logo de la Liga para la Sede de Torrelavega y las etiquetas así como el packequing para los productos que se vendarán a través del RETO Foodtruck.',
            'estudio_id' => Estudio::find(4)->id,
            
        ],
        [
            'titulo' => 'EXPO “BARRIOGRAFÍA DE LA INCLUSIÓN”',
            'texto' => 'Desde la familia profesional de Servicios Socioculturales y a la Comunidad el IES Besaya a través de su ciclo Grado Superior en Integración Social han diseñado la exposición BARRIOGRAFÍA DE LA INCLUSIÓN. Esta exposición muestra como las cosas que vemos cambian dependiendo de los ojos que usemos para verlas, del tiempo que tomemos para observarlas y del lado de la calle donde nos situemos para hacerlo. Por lo tanto, es una experiencia de intervención socioeducativa basada en una exposición de fotografías realizadas por el alumnado de primer curso de integración social durante una salida por los barrios de Torrelavega.',
            'estudio_id' =>Estudio::find(6)->id,
        ],
        [
            'titulo' => 'Entrenador Automatizado',
            'texto' => 'se diseñará un sistema de entrenamiento automatizado, en el que diferentes tipos de transductores enviarán una señal, para que el jugador pueda pasar al siguiente ejercicio. cuando el jugador finalice el entrenamiento se activará una baliza y se indicarán en el visualizador los valores conseguidos. para poder realizarlo el control de los datos dados por los sensores se realizará mediante un automata.',
            'estudio_id' => Estudio::find(7)->id,
        ],
        [
            'titulo' => 'Monitorización cardiaca y aviso a emergencias',
            'texto' => 'El sistema mide el ritmo cardiaco de un jugador y si entraña riesgo para su salud envía un wasap al árbritro, al móvil o en su defecto a un Smartwatch, y a urgencias para que pare el juego y se actue en consecuencia, si en las gradas un espectador sufre un paro cardiaco, disponemos de un pulsador que también activa todo este protocolo de emergencia, cumpliendo con la nueva normativa en los estadios.',
            'estudio_id' => Estudio::find(8)->id,
        ],
        [
            'titulo' => 'Masaje deportivo',
            'texto' => 'El alumnado tiene que preparar una rutina de masajes deportivos, este alumnado lo implementará después de los entrenamientos y de los partidos para prevenir lesiones en los deportistas.',
            'estudio_id' => Estudio::find(10)->id,
        ],
        [
            'titulo' => 'Jabones solidarios',
            'texto' => 'El proyecto consiste en elaborar diferentes tipos de jabones en el laboratorio de cosmetología para poder venderlos y contribuir a la recaudación de fondos.',
            'estudio_id' => Estudio::find(10)->id,
        ],
        [
            'titulo' => 'Tratamientos hidrotermales en el deporte',
            'texto' => 'En este reto se trabajará el RA6, y por tanto el alumnado aplicará técnicas hidroestéticas y cosméticos termales, siguiendo un protocolo de ejecución previamente diseñado y basado en las indicaciones de dichos tratamientos en deportistas.
            Los componentes de los equipos del IES Zapatón, en grupos de 6 podrán acudir a realizarse dichos tratamientos al aula de hidrotermales.',
            'estudio_id' => Estudio::find(10)->id,
        ],
        [
            'titulo' => 'Retransmisión televisiva del evento',
            'texto' => 'Los alumnos de 1º de VideoDJ darán cobertura televisiva del evento. Se realizará con 3 cámaras y se hará una retransmisión en directo por Youtube. Será una colaboración con los alumnos del ciclo de SAE que se encargarán de la sonorización.',
            'estudio_id' => Estudio::find(11)->id,
        ],
        [
            'titulo' => 'Sonorización del evento',
            'texto' => 'Los alumnos de 1º de SAE darán cobertura en materia de sonorización en el evento. Se sonorizará el pabellón donde tengan lugar los partidos, y además se dará cobertura a los alumnos del ciclo de VideoDJ que estarán haciendo una retransmisión en vídeo del evento que a su vez se difundirá en directo a través del canal de Youtube.',
            'estudio_id' => Estudio::find(12)->id,
        ],
        [
            'titulo' => 'Despliegue de red para un evento deportivo',
            'texto' => 'En el pabellón de la Habana Vieja se desplegará una red local MESH para la conexión de los dispositivos del evento. Esta red podrá ser utilizada por los aficionados, los participantes en los retos e incluso para retransmitir los partidos en streaming. La red tendrá una salida dual pudiendo conectarse a Internet a través de 5G o de la red del propio pabellón. Se configurará, además, un equipo para la administración de dicha red.',
            'estudio_id' =>Estudio::find(13)->id,
        ],
        [
            'titulo' => 'Diseño y desarrollo web sede torrelavega',
            'texto' => 'Se realiza una pagina web para la liga solidaria que apadrina la **Cruz Roja** con sede en Torrelavega. En esta página se debe de dessarrollar una gestión de usuarios y diversas funcionalidades y diseños para hacerla lo más amena, cercana e informativa para todos aquellos que participen en el torneo, además de realizar la gestión de los resultados de la propia liga que se celebra entre los días **13 y 14 de marzo de 2025**.
Por si fuese poco, también se da visibilidad a los diferentes retos realizados por otros modulos profesionales, sponsors que han participado en el torneo y a la propia benefactora del torneo, la Cruz Roja.',
            'estudio_id' => Estudio::find(14)->id,
        ],
        [
            'titulo' => 'Despliegue de un servidor de virtualización para el alojamiento de las páginas web del la sede del torneo',
            'texto' => 'Se desplegará el hardware y software necesario para alojar los servicios web que se implanten en los diferentes retos de la sede de Torrelavega. Se adquirirá y configurará para ello un equipo con suficiente capacidad de cómputo y de almacenamiento para realizar las funciones de servidor. Este equipamiento informático, cuya ubicación está por determinar, podrá ser utilizado por los participantes de los retos de los tres centros.',
            'estudio_id' => Estudio::find(15)->id,
        ],
        [
            'titulo' => 'Exhibición de un vehículo inercial para descensos',
            'texto' => 'Se llevará a cabo la construcción y diseño de un vehículo inercial, optimizado específicamente para participar en competencias de descenso, destacándose por su rendimiento, innovación y seguridad. Este vehículo, resultado de un proceso creativo y técnico, será exhibido y presentado como pieza central durante la celebración del torneo, donde se destacará tanto su diseño como su desempeño en condiciones reales de competencia.',
            'estudio_id' => Estudio::find(16)->id,
        ],
        [
            'titulo' => 'Gestión de una empresa de eventos deportivos',
            'texto' => 'El reto que se llevará a cabo en gestión de empresa incluirá diversos aspectos clave relacionados con la administración y promoción del torneo.
Por un lado, se realizará la gestión contable de la sociedad deportiva encargada de organizar el torneo de fútbol solidario, lo que implica llevar a cabo tareas como el registro de ingresos y gastos, análisis financiero, elaboración de presupuestos, y generación de reportes que reflejen la viabilidad económica del evento. Por otro lado, se simularán las funciones propias de un Community Manager, enfocándose en la creación de estrategias para la difusión del torneo en redes sociales, la gestión de contenido atractivo y dinámico, la interacción con la comunidad digital, y el fortalecimiento de la imagen del evento en plataformas en línea. Este reto busca integrar conocimientos administrativos y de marketing digital para ofrecer una experiencia práctica y completa.',
            'estudio_id' => $estudios->last()->id,
        ],
    ];

    foreach ($retos as $reto) {
        Reto::create([
            'titulo' => $reto['titulo'],
            'texto' => $reto['texto'],
            'estudio_id' => $reto['estudio_id'],
        ]);
    }
}
}
