<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use SparkPost\SparkPost;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class School extends Model
{
    use Notifiable;

	protected $table = 'schools';

    protected $fillable = ['name'];

    public $rules = array(
        'name' => 'required'
    );

    protected static $titles = [
        'elect_eur' => 'Electricity Euros',
        'elect_kwh' => 'Electricity Usage',
        'heating_eur' => 'Heating Euros',
        'heating_kwh' => 'Heating Usage',
        'water_eur' => 'Water Euros',
        'water_litres' => 'Water Usage',
    ];

    protected static $yAxis = [
        'elect_eur' => 'Euros',
        'elect_kwh' => 'kWh',
        'heating_eur' => 'Euros',
        'heating_kwh' => 'kWh',
        'water_eur' => 'Euros',
        'water_litres' => 'Litres',
    ];

    protected static $benchmark = [
        'elect_kwh' => 'benchmark_elect',
        'heating_kwh' => 'benchmark_heating',
        'water_litres' => 'benchmark_water',
    ];

    /**
     * @param string $type
     * @param int $year
     * @param int $month
     * @return array
     */
    public function chart($type, $year, $month)
    {
        $result = $this->getChartData($year, $month);

        $series = $month ? date('F Y', strtotime($year . '-' . $month . '-01')) : $year;

        $categories = [];
        $data = [];
        foreach ($result as $item) {
            $data[] = (float)$item->$type;
            $categories[] = $month ? "Week " . $item->iterator : date('F', strtotime($year . '-' . $item->iterator . '-01'));
        }

        $filename = $this->name . '_' . str_replace(' ', '_', self::$titles[$type]) . '_' . ($month ? date('F_Y', strtotime($year . '-' . $month . '-01')) : $year);

        $benchmark = isset(self::$benchmark[$type]) ? self::$benchmark[$type] : null;

        return [
            'categories' => $categories,
            'data' => $data,
            'name' => $this->name . ' ' . self::$titles[$type],
            'yAxis' => self::$yAxis[$type],
            'series' => $series,
            'filename' => $filename,
            'plotLines' => json_decode(($benchmark && $this->$benchmark > 0) ? '[{
                "zIndex": 100,
                "value": '.$this->$benchmark.',
                "color": "red",
                "dashStyle": "solid",
                "width": 1,
                "label": {
                  "style": {
                    "color": "red",
                    "fontWeight": "bold"
                  },
                  "text": "' . $this->$benchmark . ' ' . self::$yAxis[$type] . '",
                  "textAlign": "left",
                  "x": -30
                }
              }]' : '[{
                "zIndex": 120,
                "value": 0,
                "color": "red",
                "dashStyle": "solid",
                "width": 0,
                "label": {
                  "style": {
                    "color": "red",
                    "fontWeight": "bold"
                  },
                  "text": "",
                  "textAlign": "left",
                  "x": -30
                }
              }]', true)
        ];
    }

    /**
     * @param int $year
     * @param int|null $month
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getChartData($year, $month = null)
    {
        // by month
        if ($month) {
//			$first_week = (int)date('W', strtotime($year . '-' . $month . '-01'));
//			$number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//			$last_week = date('W', strtotime($year . '-' . $month . '-' . $number));

            $result = SchoolStatistics::select('elect_eur', 'elect_kwh', 'heating_eur', 'heating_kwh', 'water_eur', 'water_litres', 'week as iterator')
                ->where('school_id', $this->id)
                ->where('year', '=', $year)
                ->where('month', '=', $month)
                ->orderBy('week')
                ->get();
        } else {
            // by year
            $result = SchoolStatistics::select(DB::raw('SUM(elect_eur) as elect_eur, SUM(elect_kwh) as elect_kwh, SUM(heating_eur) as heating_eur, SUM(heating_kwh) as heating_kwh, SUM(water_eur) as water_eur, SUM(water_litres) as water_litres, month as iterator'))
                ->where('school_id', $this->id)
                ->where('year', '=', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function years()
    {
        $years = [];
        for ($i = 2012; $i <= 2030; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }

    /**
     * @return array
     */
    public static function months()
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('F', mktime(0, 0, 0, $i, 10));
        }
        return $months;
    }

    /**
     * @return array
     */
    public static function weeks()
    {
        $weeks = [];
        for ($i = 1; $i <= 53; $i++) {
            $weeks[$i] = $i;
        }
        return $weeks;
    }

    /**
     * @param string $email
     * @param string $subject
     * @param array $files
     */
    public static function send($email, $subject, $files)
    {
        $httpAdapter = new GuzzleAdapter(new Client());
        $sparky = new SparkPost($httpAdapter, ['key' => env('SPARK_KEY')]);

        $attachments = [];
        foreach ($files as $file) {
            $attachments[] = [
                'name' => $file,
                'type' => 'image/png',
                'data' => base64_encode(file_get_contents(storage_path('charts/' . $file)))
            ];
        }

        $promise = $sparky->transmissions->post([
//			'options' => [
//				'sandbox' => true,
//			],
            'content' => [
                'from' => 'info@codingchipmunks.com',
                'html' => '',
                'subject' => $subject,
                'attachments' => $attachments
            ],
            'recipients' => [
                [
                    'address' => [
                        'email' => $email
                    ]
                ]
            ]
        ]);
        try {
            $response = $promise->wait();
//            echo $response->getStatusCode() . "\n";
//            print_r($response->getBody()) . "\n";
        } catch (\Exception $e) {
            echo $e->getCode() . "\n";
            echo $e->getMessage() . "\n";
        }
    }

    public function download($chart, $year, $month)
    {
        $data = $this->chart($chart, $year, $month);

        $filename = $data['filename'] . '.png';
        $file_path = fopen(storage_path('charts/' . $filename),'w');

        $json = '{  
           "infile":{  
              "chart":{"type":"column","backgroundColor":"#DCDCDC","options3d":{"enabled":true,"alpha":0,"beta":20,"depth":50,"viewDistance":999}},
              "plotOptions":{"series":{"dataLabels":{"enabled":true,"align":"center","color":"#000000","verticalAlign":"top"},"pointPadding":0.1,"groupPadding":0}},
              "title":{  
                 "text":"' . $data['name'] . '"
              },
              "xAxis":{  
                 "categories":' . json_encode($data['categories']) . ',
                 "labels":{"skew3d":true,"style":{"fontSize":"16px"}}
              },
              "yAxis":{"allowDecimals":false,"min":0,"title":{"text":"' . $data['yAxis'] . '","skew3d":true},"plotLines":'.json_encode($data['plotLines']).'},
              "series":[{
                "name":' . json_encode($data['series']) . ',
                "data":' . json_encode($data['data']) . '
              }]
           }
        }';

//        echo $json;die;

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $result = $client->post(env('HIGHCHARTS_EXPORT_SERVER'), [
            'body' => $json,
            'save_to' => $file_path
        ]);
        return $filename;
    }
}
