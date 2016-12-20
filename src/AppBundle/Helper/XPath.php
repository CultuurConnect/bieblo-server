<?php

namespace AppBundle\Helper;

class XPath {
    /**
     * @param string $query
     * @return string
     */
    static public function holding($query) {
        return sprintf('//holding[%s]', $query);
    }

    /**
     * @return string
     */
    static public function province() {
        $isAbstract = '@abstract=\'true\'';
        $parentIsRoot = '@parent=\'/root/bibnet\'';
        $query = sprintf('%s and %s', $isAbstract, $parentIsRoot);
        return self::holding($query);
    }

    /**
     * @param \AppBundle\Entity\Region $province
     * @return string
     */
    static public function provinceRegion(\AppBundle\Entity\Region $province) {
        $parentIsProvince = sprintf('@parent=\'%s\'', $province->getId());
        $biosGeneratedHoofd = 'starts-with(@bios, \'GENERATED_HOOFD_\')';
        $query = sprintf('%s and %s', $parentIsProvince, $biosGeneratedHoofd);
        return self::holding($query);
    }

    /**
     * @return string
     */
    static public function library()
    {
        $biosStartBib = 'starts-with(@bios, \'BIB-\')';
        $biosStartLoc = 'starts-with(@bios, \'LOC-\')';
        $biosGeneratedBed = 'starts-with(@bios, \'GENERATED_BED_\')';
        $query = sprintf('%s or %s or %s', $biosStartBib, $biosStartLoc, $biosGeneratedBed);
        return self::holding($query);
    }

    static public function count()
    {
        return '//count';
    }

    static public function page()
    {
        return '//page';
    }

    static public function book()
    {
        return '//result';
    }

    static public function location($id) {
        return sprintf('//location[@id="%s"]', $id);
    }
}