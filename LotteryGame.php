<?php

class LotteryGame
{

    private int $length;
    private int $quantity;
    private array $result;
    private array $bets;

    /**
     * @param int $length
     * @param int $quantity
     * @throws Exception
     */
    public function __construct(int $length, int $quantity)
    {
        $this->quantity = $quantity > 0 ? $quantity : 1;
        $this->length  = $this->validateLength($length);
    }

    /**
     * @param int $length
     * @return int
     * @throws Exception
     */
    private function validateLength(int $length): int
    {
        if ($length < 6 || $length > 10) {
            throw new Exception('Quantidade de dezenas deve ser entre 6 e 10');
        }

        return $length;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return $this
     */
    public function setLength(int $length): LotteryGame
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity): LotteryGame
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param array $result
     * @return $this
     */
    public function setResult(array $result): LotteryGame
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return void
     */
    public function generateBets(): void
    {
        for ($i = 0; $i < $this->quantity; $i++) {
            $this->addBet($this->drawDozens($this->length));
        }
    }

    public function addBet(array $bet): LotteryGame
    {
        $this->bets[] = $this->validateBet($bet);
        return $this;
    }

    /**
     * @param array $bet
     * @return array
     * @throws Exception
     */
    private function validateBet(array $bet): array
    {
        if (count($bet) !== $this->length) {
            throw new Exception("Uma aposta deve possuir $this->length dezenas.");
        }

        return $bet;
    }

    /**
     * @param int $length
     * @return array
     */
    private function drawDozens(int $length): array
    {
        $bet = [];
        $count = 1;
        while ($count <= $length) {
            $current = rand(1, 60);

            if (in_array($current, $bet)) {
                continue;
            }

            $bet[] = $current;
            $count++;
        }
        sort($bet);
        return $bet;
    }

    public function generateResult()
    {
        $this->setResult($this->drawDozens(6));
    }

    public function showTable()
    {
        echo "<h2>Resultados</h2>";
        echo "<table>";

        echo $this->addRow($this->result, true);
        echo "</table>";

        $bets = $this->getBets();

        echo "<h2>Apostas</h2>";
        echo "<table>";
        foreach ($bets as $bet) {
            echo '<PRE>';
            echo $this->addRow($bet, false);
        }

        echo "</table>";
    }

    private function addRow(array $data, bool $isResult)
    {
        $row = '<tr>';

        foreach ($data as $item) {
            $class = (!$isResult && in_array($item, $this->result)) ? 'match' : null;
            $row .= "<td class='${class}'>$item</td>";
        }
        $row .= '</tr>';

        return $row;
    }

    /**
     * @return array
     */
    public function getBets(): array
    {
        return $this->bets;
    }

}