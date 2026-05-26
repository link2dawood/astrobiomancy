<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedTestimonials extends Migration
{
    /**
     * Seed 6 testimonials in EN + matching DE translations (12 rows total).
     * Idempotent: each (name, lang) pair is only inserted when absent.
     */
    public function up()
    {
        if (!Schema::hasTable('testimonials')) {
            return;
        }

        $items = [
            [
                'name' => 'Anna M.',
                'date' => '2025-09-12',
                'en'   => 'My biomantic reading with Astrobiomancy gave me clarity I had been looking for for years. The session was warm, precise and never made me feel judged. I have referred three friends since.',
                'de'   => 'Meine biomantische Lesung bei Astrobiomancy hat mir die Klarheit gegeben, nach der ich jahrelang gesucht habe. Die Sitzung war herzlich, präzise und nie wertend. Ich habe seitdem drei Freundinnen weiterempfohlen.',
            ],
            [
                'name' => 'Markus K.',
                'date' => '2025-11-03',
                'en'   => 'The energy work session left me feeling lighter than I have in a decade. Whatever blockage I was carrying — it is gone. Skeptical going in, completely converted coming out.',
                'de'   => 'Die Energiearbeit-Sitzung hat mich leichter zurückgelassen als seit zehn Jahren. Welche Blockade ich auch mitgebracht habe — sie ist weg. Skeptisch hineingegangen, vollständig überzeugt herausgekommen.',
            ],
            [
                'name' => 'Sophie L.',
                'date' => '2026-01-22',
                'en'   => 'I came for dietary advice and stayed for the deeper conversation about what my body was actually asking for. Three months later my energy levels and sleep have completely changed.',
                'de'   => 'Ich kam für eine Ernährungsberatung und blieb wegen des tiefergehenden Gesprächs darüber, was mein Körper wirklich brauchte. Drei Monate später haben sich mein Energielevel und mein Schlaf vollständig verändert.',
            ],
            [
                'name' => 'David R.',
                'date' => '2026-02-08',
                'en'   => 'The geomantic reading on our new home was uncanny — every detail aligned with what we were sensing but could not articulate. We rearranged a few rooms based on the advice and the difference is real.',
                'de'   => 'Die geomantische Lesung für unser neues Zuhause war unheimlich treffend — jedes Detail stimmte mit dem überein, was wir spürten, aber nicht in Worte fassen konnten. Wir haben einige Räume nach den Empfehlungen umgestellt, und der Unterschied ist spürbar.',
            ],
            [
                'name' => 'Lena B.',
                'date' => '2026-03-15',
                'en'   => 'What I appreciated most was how grounded everything felt. No theatrics, no vagueness. Practical guidance that I could actually use the same week.',
                'de'   => 'Was ich am meisten geschätzt habe, war wie geerdet alles war. Keine Effekthascherei, keine Vagheit. Praktische Hinweise, die ich noch in derselben Woche umsetzen konnte.',
            ],
            [
                'name' => 'Thomas H.',
                'date' => '2026-04-29',
                'en'   => 'I have worked with several astrologers over the years. The astrobiomantic approach here is something different — it treats the body and the chart as one system. That framing alone shifted how I think about my health.',
                'de'   => 'Ich habe über die Jahre mit mehreren Astrologen gearbeitet. Der astrobiomantische Ansatz hier ist etwas anderes — er betrachtet Körper und Geburtschart als ein System. Allein diese Sichtweise hat verändert, wie ich über meine Gesundheit denke.',
            ],
        ];

        foreach ($items as $sort => $row) {
            // EN row
            $enExists = DB::table('testimonials')
                ->where('name', $row['name'])->where('lang', 'en')->exists();
            if (!$enExists) {
                $enId = DB::table('testimonials')->insertGetId([
                    'lang'           => 'en',
                    'name'           => $row['name'],
                    'content'        => $row['en'],
                    'photo'          => null,
                    'display_date'   => $row['date'],
                    'sort'           => $sort + 1,
                    'status'         => 'Published',
                    'translation_of' => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            } else {
                $enId = DB::table('testimonials')
                    ->where('name', $row['name'])->where('lang', 'en')->value('id');
            }

            // DE row linked to the EN id
            $deExists = DB::table('testimonials')
                ->where('name', $row['name'])->where('lang', 'de')->exists();
            if (!$deExists) {
                DB::table('testimonials')->insert([
                    'lang'           => 'de',
                    'name'           => $row['name'],
                    'content'        => $row['de'],
                    'photo'          => null,
                    'display_date'   => $row['date'],
                    'sort'           => $sort + 1,
                    'status'         => 'Published',
                    'translation_of' => $enId,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('testimonials')) {
            $names = ['Anna M.', 'Markus K.', 'Sophie L.', 'David R.', 'Lena B.', 'Thomas H.'];
            DB::table('testimonials')->whereIn('name', $names)->delete();
        }
    }
}
