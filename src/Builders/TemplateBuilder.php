<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Builders;

class TemplateBuilder
{
    /**
     * @var array
     */
    private $params = [];

    /**
     * Set template name.
     */
    public function setName(string $name): self
    {
        $this->params['setting_name'] = $name;

        return $this;
    }

    /**
     * Set redirect type.
     */
    public function setRedirectType(string $type): self
    {
        $this->params['redirect_type'] = $type;

        return $this;
    }

    /**
     * Set redirect delay in seconds.
     */
    public function setRedirectDelay(int $delay): self
    {
        $this->params['redirect_delay'] = $delay;

        return $this;
    }

    /**
     * Set unique type.
     */
    public function setUniqueType(string $type): self
    {
        $this->params['unique_type'] = $type;

        return $this;
    }

    /**
     * Set auto delete hours.
     */
    public function setAutoDelete(int $hours): self
    {
        $this->params['auto_delete'] = $hours;

        return $this;
    }

    /**
     * Enable/disable auto bind.
     */
    public function setAutoBind(bool $enabled): self
    {
        $this->params['auto_bind'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable ban check.
     */
    public function setBanCheck(bool $enabled): self
    {
        $this->params['is_ban_check'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable random phrases.
     */
    public function setRandomPhrases(bool $enabled): self
    {
        $this->params['is_random_phraze'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable preview.
     */
    public function setPreview(bool $enabled): self
    {
        $this->params['is_preview'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable GET parameter forwarding.
     */
    public function setSendGet(bool $enabled): self
    {
        $this->params['send_get'] = $enabled;

        return $this;
    }

    /**
     * Set minimum symbols count.
     */
    public function setMinSymbols(int $count): self
    {
        $this->params['min_symbols'] = $count;

        return $this;
    }

    /**
     * Set maximum symbols count.
     */
    public function setMaxSymbols(int $count): self
    {
        $this->params['max_symbols'] = $count;

        return $this;
    }

    /**
     * Enable/disable reg1.
     */
    public function setReg1(bool $enabled): self
    {
        $this->params['reg1'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable reg2.
     */
    public function setReg2(bool $enabled): self
    {
        $this->params['reg2'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable numbers in URLs.
     */
    public function setNumbers(bool $enabled): self
    {
        $this->params['s_nums'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable subdomains.
     */
    public function setSubdomains(bool $enabled): self
    {
        $this->params['subDomains'] = $enabled;

        return $this;
    }

    /**
     * Set bot list.
     */
    public function setBotList(array $bots): self
    {
        $this->params['bot_list'] = $bots;

        return $this;
    }

    /**
     * Set white referrer.
     */
    public function setWhiteReferrer(string $referrer): self
    {
        $this->params['white_refferer'] = $referrer;

        return $this;
    }

    /**
     * Enable/disable audio.
     */
    public function setHasAudio(bool $enabled): self
    {
        $this->params['hasAudio'] = $enabled;

        return $this;
    }

    /**
     * Enable/disable ban all.
     */
    public function setBanAll(bool $enabled): self
    {
        $this->params['ban_all'] = $enabled;

        return $this;
    }

    /**
     * Set minimum hour.
     *
     * @param int $hour 0-24
     */
    public function setMinHour(int $hour): self
    {
        $this->params['minHour'] = $hour;

        return $this;
    }

    /**
     * Set maximum hour.
     *
     * @param int $hour 0-24
     */
    public function setMaxHour(int $hour): self
    {
        $this->params['maxHour'] = $hour;

        return $this;
    }

    /**
     * Set bot redirect behavior.
     *
     * @param string $redirect 'no' for 300 code, or specific redirect
     */
    public function setBotRedirect(string $redirect): self
    {
        $this->params['bot_redirect'] = $redirect;

        return $this;
    }

    /**
     * Build parameters array.
     */
    public function build(): array
    {
        return $this->params;
    }

    /**
     * Get parameters as array (alias for build).
     */
    public function toArray(): array
    {
        return $this->build();
    }
}
