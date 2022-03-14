<?php

namespace Tests\Unit\RiskProfileService\ScoreCalculators;

use App\Services\Risk\ScoreCalculators\BaseRiskScore;

class BaseRiskScoreTest extends RiskScoreTestCase
{
    /** @dataProvider riskQuestionsAnswersDataProvider */
    public function testUserWithDifferentRiskQuestionsAnswersShouldChangeProfilesRespectively(array $answers, int $expected): void
    {
        $this->input->riskQuestions = $answers;
        $calculator = new BaseRiskScore($this->input);
        $baseScore = $calculator->calculate();

        foreach ($baseScore as $value) {
            $this->assertEquals($expected, $value);
        }
    }

    public function riskQuestionsAnswersDataProvider(): array
    {
        return [
            [
                'answers' => [0, 0, 0],
                'expected' => 0,
            ],
            [
                'answers' => [0, 1, 0],
                'expected' => 1,
            ],
            [
                'answers' => [1, 1, 0],
                'expected' => 2,
            ],
            [
                'answers' => [1, 1, 1],
                'expected' => 3,
            ],
        ];
    }
}
