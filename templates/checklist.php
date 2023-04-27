<?php
    /** Импортируемые переменные */
    /** @var array $audit */
    /** @var int $auditid */
    /** @var int $checkid */
    /** @var array $checklist_color */
    /** @var array $criteria_titles */
    /** @var array $checklists */
    /** @var array $marks */
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/audit?id=<?=$auditid?>" class="back"><?=$audit['title']?></a> ⇢ (<?=$checkid?>) <?=$criteria_titles[$checkid]?></span></div>
    </div>
</div>

<div class="top-placeholder"></div>

<style>
    * {
        --check-color: <?=$checklist_color[$checkid][2]?>;
        --check-color-darken: <?=$checklist_color[$checkid][3]?>;
        --check-color-pending: <?=$checklist_color[$checkid][4]?>;
        --check-color-pale: <?=$checklist_color[$checkid][4]?>40;
    }

    .top {
        background-color: <?=$checklist_color[$checkid][0]?> !important;
    }

    .top__title {
        height: 100%;
        display: flex;
        align-items: center;
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
    }
</style>

<script>
    let auditid = <?=$auditid?>;
    let checklistid = <?=$checkid?>;
</script>

<div class="content">
    <div class="container checklist-container">
        <h1><a href="/audit?id=<?=$auditid?>" class="back">⇠</a> (<?=$checkid?>) <?=$criteria_titles[$checkid]?></h1>
        <div class="checklistform">

            <?php foreach ($checklists[$checkid]['categories'][0] as $i => $category): ?>

                <div class="category">
                    <div class="category__title" data-category="<?=$i?>"><span><?=$category?></span>
                        <svg class="closed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z"/></svg><svg class="opened" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg></div>
                    <div id="category-<?=$i?>">

                        <?php foreach ($checklists[$checkid]['categories'][1][$i] as $criterianum): ?>

                            <form class="criteria">
                                <p class="criteria__text"><?=$criterianum+1?>. <?=$checklists[$checkid]['criteria'][$criterianum]?></p>
                                <div class="criteria__marks" >
                                    <div class="criteria__marks-flex">

                                        <?php if ($checkid !== 2 or in_array(0, $checklists[2]['custommarks'][$criterianum])): ?>

                                            <label class="criteria__mark">
                                                <input type="radio" name="mark" data-criteria="<?=$criterianum?>" value="0" hidden <?=$marks[$checkid][$criterianum] === 0 ? 'checked' : ''?>>
                                                <span>0,00</span>
                                            </label>

                                        <?php endif; if ($checkid !== 2 or in_array(0.25, $checklists[2]['custommarks'][$criterianum])): ?>

                                            <label class="criteria__mark">
                                                <input type="radio" name="mark" data-criteria="<?=$criterianum?>" value="0.25" hidden <?=$marks[$checkid][$criterianum] === 0.25 ? 'checked' : ''?>>
                                                <span>0,25</span>
                                            </label>

                                        <?php endif; if ($checkid !== 2 or in_array(0.5, $checklists[2]['custommarks'][$criterianum])): ?>

                                            <label class="criteria__mark">
                                                <input type="radio" name="mark" data-criteria="<?=$criterianum?>" value="0.50" hidden <?=$marks[$checkid][$criterianum] === 0.5 ? 'checked' : ''?>>
                                                <span>0,50</span>
                                            </label>

                                        <?php endif; if ($checkid !== 2 or in_array(0.75, $checklists[2]['custommarks'][$criterianum])): ?>

                                            <label class="criteria__mark">
                                                <input type="radio" name="mark" data-criteria="<?=$criterianum?>" value="0.75" hidden <?=$marks[$checkid][$criterianum] === 0.75 ? 'checked' : ''?>>
                                                <span>0,75</span>
                                            </label>

                                        <?php endif; if ($checkid !== 2 or in_array(1, $checklists[2]['custommarks'][$criterianum])): ?>

                                            <label class="criteria__mark">
                                                <input type="radio" name="mark" data-criteria="<?=$criterianum?>" value="1" hidden <?=$marks[$checkid][$criterianum] === 1 ? 'checked' : ''?>>
                                                <span>1,00</span>
                                            </label>

                                        <?php endif; ?>
                                    </div>
                                    <div class="criteria__marks-flex">
                                        <label class="criteria__mark">
                                            <input type="radio" name="mark" data-criteria="<?=$criterianum?>" value="-2" hidden <?=$marks[$checkid][$criterianum] === -2 ? 'checked' : ''?>>
                                            <span>Не применим</span>
                                        </label>
                                        <label class="criteria__icon">
                                            <input type="radio" name="mark" data-criteria="<?=$criterianum?>" value="-1" hidden <?=$marks[$checkid][$criterianum] === -1 ? 'checked' : ''?>>
                                            <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg></span>
                                        </label>
                                        <label class="criteria__icon" data-markdesc="<?=$criterianum?>" id="markdesc-activator-<?=$criterianum?>">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm169.8-90.7c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg></span>
                                        </label>

                                        <?php if ($checkid !== 2): ?>

                                            <label class="criteria__icon" data-standard="<?=$criterianum?>" id="standard-activator-<?=$criterianum?>">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg></span>
                                            </label>

                                        <?php endif; ?>

                                        <label class="criteria__icon <?=strlen($audit['comments'][$checkid][$criterianum]) ? 'filled' : ''?>" data-comments="<?=$criterianum?>" id="comments-activator-<?=$criterianum?>">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg></span>
                                        </label>

                                        <!-- Иконка скрепки для будущих версий -->
                                        <!--<label class="criteria__icon">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"/></svg></span>
                                        </label>-->
                                    </div>
                                </div>
                                <div class="criteria__info" id="markdesc-<?=$criterianum?>" hidden>

                                    <?php if ($checkid === 2): ?>

                                        <div>
                                            <?=$checklists[$checkid]['standard'][$criterianum]?>
                                        </div>

                                    <?php else: ?>

                                        <div>
                                            1,00 — требование выполняется в полном объеме;<br>
                                            0,75 — требование выполняется, выявлены замечания;<br>
                                            0,50 — требование выполняется, выявлены незначительные несоответствия;<br>
                                            0,25 — требование не выполняется, разработаны корректирующие действия;<br>
                                            0,00 — требование не выполняется, корректирующие действия не разработаны.
                                        </div>

                                    <?php endif; ?>

                                </div>

                                <?php if ($checkid !== 2): ?>

                                    <div class="criteria__info" id="standard-<?=$criterianum?>" hidden>
                                        <div>
                                            Стандарт: <?=$checklists[$checkid]['standard'][$criterianum]?>
                                        </div>
                                    </div>

                                <?php endif; ?>

                                <div class="criteria__comments" id="comments-<?=$criterianum?>" hidden>
                                    <div>
                                        <textarea name="comment" placeholder="Обоснование оценки"><?=$audit['comments'][$checkid][$criterianum]?></textarea>

                                        <div class="criteria__comments-status status"></div>
                                    </div>
                                </div>
                            </form>

                        <?php endforeach; ?>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</div>